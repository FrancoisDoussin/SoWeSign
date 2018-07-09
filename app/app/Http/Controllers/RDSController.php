<?php

namespace App\Http\Controllers;

use App\Models\RDS;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Smalot\PdfParser\Parser;

class RDSController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function createAdmin(Request $request)
    {
        if (false === $request->hasFile('file')){
            return redirect()->route('index');
        }

        $file = $this->downloadFile($request);
        $rds = $this->parsePdf($file);

        return view('create-admin', [
            'rds' => $rds,
        ]);
    }

    public function context(Request $request): View
    {
        $rds = RDS::find($request->get('rds_id'));
        $rds->admin_first_name = $request->get('admin_first_name');
        $rds->admin_last_name = $request->get('admin_last_name');
        $rds->admin_email = $request->get('admin_email');
        $rds->save();

        return view('context', [
            'rds' => $rds,
        ]);
    }

    public function signatories(Request $request): View
    {
        $rds = RDS::find($request->get('rds_id'));
        $rds->name = $request->get('name');
        $rds->date = $request->get('date');
        $rds->save();

        return view('signatories', [
            'rds' => $rds,
        ]);
    }

    public function invitation(Request $request): View
    {
        $rds = RDS::find($request->get('rds_id'));
        $rds->name = $request->get('name');
        $rds->date = $request->get('date');
        $rds->save();

        return view('invitation');
    }

    public function confirmation(Request $request): View
    {
        $rds = RDS::find($request->get('rds_id'));

        dump($rds);
        dd($request);
        return view('confirmation');
    }

    private function downloadFile(Request $request): string
    {
        $file = $request->file('file');
        $downloadFile = Storage::disk('public')->put('pdf', $file);
        return Storage::disk('public')->url($downloadFile);
    }

    private function parsePdf($downloadFile): RDS
    {
        $rds = new RDS();
        $parser = new Parser();
        $content = $parser->parseFile($downloadFile);
        $text = $content->getText();

        $rds->name = 'test';
        $rds->description = 'test';
        $rds->date = new \DateTime();
        $rds->place = 'test';
        $rds->file_path = 'test';
        $rds->invitation_subject = 'test';
        $rds->invitation_delay = 1;
        $rds->invitation_frequence = 1;
        $rds->invitation_quantity = 1;
        $rds->admin_first_name = 'test';
        $rds->admin_last_name = 'test';
        $rds->admin_email = 'test@test.email';
        $rds->url_one_hash = 'test';
        $rds->url_two_hash = 'test';
        $rds->url_three_hash = 'test';
        $rds->save();

        $signatory = new Signatory();
        $signatory->first_name = 'jean';
        $signatory->last_name = 'pierre';
        $signatory->email = 'test@test.email';
        $signatory->company = 'imie';
        $signatory->has_signed = 0;
        $rds->signatories()->save($signatory);

        $signatory = new Signatory();
        $signatory->first_name = 'michel';
        $signatory->last_name = 'albert';
        $signatory->email = 'jeanjean@test.email';
        $signatory->company = 'greojgreoij';
        $signatory->has_signed = 0;
        $rds->signatories()->save($signatory);

        return $rds;
    }
}
