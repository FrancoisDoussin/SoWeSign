<?php

namespace App\Repositories;

use App\Models\Signatory;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\RDS;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser;

/**
 * Class RDSRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RDSRepository extends BaseRepository
{
    private $parser;

    public function __construct(Application $app, Parser $parser)
    {
        parent::__construct($app);
        $this->parser = $parser;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RDS::class;
    }

    public function checkPdf($file_path)
    {
        $url = config('app.url') . Storage::url($file_path);

        // parse PDF
        $text = $this->parsePdf($url);

        // check if there are signatories
        if(count($this->checkSignatories($text)[0]) == 0) {
            return 0;
        }

        session(['nb_signatories' => count($this->checkSignatories($text)[0])]);

        // get signatories position
        try {
            $client = new Client();
            $res = $client->request('POST', config('services.pdf_microservice.url') . '/pdf', [
                'multipart' => [
                    [
                        'name'     => 'pdf',
                        'contents' => file_get_contents($url),
                        'filename' => 'pdf_file'
                    ]
                ],
            ]);

            $data = json_decode($res->getBody())->data;

            session(['signatories_positions' => $data]);
        }
        catch (\Exception $e) {
            return 0;
        }

        // get tags
        try {
            $tags = $this->getTags($text);
            session(['tags' => $tags]);
        }
        catch (\Exception $e) {
            return 0;
        }

        session(['file_path' => $file_path]);

        return 1;
    }

    private function parsePdf($url)
    {
        $pdf = $this->parser->parseFile($url);

        $text = $pdf->getText();

        return $text;
    }

    private function checkSignatories($text)
    {
        $pattern = '/^(#SIGN)(.[^#]*)(#)/m';
        preg_match_all($pattern, $text, $matches);
        return $matches;
    }

    private function getTags($text)
    {
        $tags = [];

        // Admin
        $admin_pattern = '/^(#ADMIN#)(.[^#]*|)(#)(.[^#]*|)(#)(.[^#]*|)(#)/m';
        preg_match($admin_pattern, $text, $admin_tags);

        $tags['admin'] = [
            'lastname' => $admin_tags[2],
            'firstname' => $admin_tags[4],
            'email' => $admin_tags[6],
        ];

        // Users
        $admin_pattern = '/^(#USER)(.[^#]*)(#)(.[^#]*|)(#)(.[^#]*|)(#)(.[^#]*|)(#)(.[^#]*|)(#)/m';
        preg_match_all($admin_pattern, $text, $users_tags);

        $nb_users = count($users_tags[0]);

        for ($i = 0; $i < $nb_users; $i ++) {
            $tags['users'][] = [
                'id' => $users_tags[2][$i],
                'lastname' => $users_tags[4][$i],
                'firstname' => $users_tags[6][$i],
                'company' => $users_tags[8][$i],
                'email' => $users_tags[10][$i],
            ];
        }

        // Meeting
        $meeting_pattern = '/^(#MEETING#)(.[^#]*|)(#)(.[^#]*|)(#)/m';
        preg_match($meeting_pattern, $text, $meeting_tags);

        $tags['meeting'] = [
            'subject' => $meeting_tags[2],
            'description' => $meeting_tags[4],
        ];

        // Schedule
        $schedule_pattern = '/^(#SCHEDULE#)(.[^#]*|)(#)(.[^#]*|)(#)(.[^#]*|)(#)(.[^#]*|)(#)/m';
        preg_match($schedule_pattern, $text, $schedule_tags);

        $date = new Carbon($schedule_tags[2]);
        $time = new Carbon($schedule_tags[4]);

        $tags['schedule'] = [
            'date' => $date->toDateString(),
            'time' => $time->format('H:i'),
            'place' => $schedule_tags[6],
            'url' => $schedule_tags[8],
        ];

        // Subject
        $subject_pattern = '/^(#SUBJECT#)(.[^#]*|)(#)(.[^#]*|)(#)/m';
        preg_match($subject_pattern, $text, $subject_tags);

        $tags['invitation'] = [
            'subject' => $subject_tags[2],
            'description' => $subject_tags[4],
        ];

        // Retry
        $retry_pattern = '/^(#RETRY#)(.[^#]*|)(#)(.[^#]*|)(#)(.[^#]*|)(#)/m';
        preg_match($retry_pattern, $text, $retry_tags);

        $tags['retry'] = [
            'delay' => $retry_tags[2],
            'quantity' => $retry_tags[4],
            'frequency' => $retry_tags[6],
        ];

        return $tags;
    }

    public function addSign(Signatory $signatory)
    {
        try {
            // get rds
            $rds = $signatory->rds;

            // get pdf path, get the signed version if exists
            if (file_exists(storage_path('app/public/pdf/signed/' . $rds->file_name . '.pdf'))) {
                $pdf_path = storage_path('app/public/pdf/signed/' . $rds->file_name . '.pdf');
            } else {
                $pdf_path = storage_path('app/public/pdf/' . $rds->file_name . '.pdf');
            }

            // get sign path
            $sign_path = storage_path('app/public' . $signatory->sign_path);

            // set output path
            $output_path = storage_path('app/public/pdf/signed/' . $rds->file_name . '.pdf');

            // get page number
            $page_number = $signatory->coord->page;
            $x = $signatory->coord->x * 5.5; // valeur trouvée de manière empirique...
            $y = $signatory->coord->y * 5.5;
            $width = $signatory->coord->w * 0.3528; // tx de conversion point typographic -> mm
            $height = $width;

            // get number of pages
            $pdfParsed = $this->parser->parseFile($pdf_path);
            $nb_pages = $pdfParsed->getDetails()['Pages'];

            // generate new pdf
            $pdf = new Fpdi();

            // create pages
            for ($i = 1; $i <= $nb_pages; $i ++) {
                $pdf->AddPage();
                $pdf->setSourceFile($pdf_path);
                $template = $pdf->importPage($i);
                $pdf->useTemplate($template);

                // add sign
                if ($i == $page_number) {
                    $pdf->Image($sign_path, $x, $y, $width, $height);
                }
            }

            // export pdf
            $pdf->Output($output_path, "F");

            return 'success';
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return 'error';
        }

    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
