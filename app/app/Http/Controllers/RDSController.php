<?php

namespace App\Http\Controllers;

use App\Models\RDS;
use App\Models\Signatory;
use App\Repositories\RDSRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class RDSController extends Controller
{
    private $rdsRepository;

    public function __construct(RDSRepository $rdsRepository)
    {
        $this->rdsRepository = $rdsRepository;
    }

    public function index(): View
    {
        return view('01-index');
    }

    public function parsePDF(Request $request)
    {
        $file_path = $request->file('pdf')->store('public/pdf');

        $check = $this->rdsRepository->checkPdf($file_path);

        if ($check == 0) {
            return redirect('/')->with('error', 'No signatories detected');
        }

        return redirect('/admin');
    }

    public function createAdmin(): View
    {
        $admin = session('tags')['admin'];

        return view('02-admin', compact('admin'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'admin_first_name' => 'required|max:255',
            'admin_last_name' => 'required|max:255',
            'admin_email' => 'required|email',
        ]);

        $rds = new RDS();
        $rds->admin_first_name = $request->get('admin_first_name');
        $rds->admin_last_name = $request->get('admin_last_name');
        $rds->admin_email = $request->get('admin_email');

        $file_name = str_replace('public/pdf/', '', session('file_path'));
        $file_name = str_replace('.pdf', '', $file_name);
        $rds->file_name = $file_name;

        session(['rds' => $rds]);

        return redirect('/context');
    }

    public function createContext(): View
    {
        $meeting = session('tags')['meeting'];
        $schedule = session('tags')['schedule'];

        return view('03-context', compact('meeting', 'schedule'));
    }

    public function storeContext(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'description' => 'required|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'place' => 'required|max:255',
            'url' => 'required|url',
        ]);

        $complete_date = new Carbon($request->get('date') . ' ' . $request->get('time'));

        $rds = session('rds');

        $rds->subject = $request->get('subject');
        $rds->description = $request->get('description');
        $rds->date = $complete_date;
        $rds->place = $request->get('place');
        $rds->url = $request->get('url');

        session(['rds' => $rds]);

        return redirect('/signatories');
    }

    public function createSignatories(): View
    {
        $nb_signatories = session('nb_signatories');
        $signatories = session('tags')['users'];

        return view('04-signatories', compact('nb_signatories','signatories'));
    }

    public function storeSignatories(Request $request)
    {
        $request->validate([
            "signatories.*.firstname" => 'required|max:255',
            "signatories.*.lastname" => 'required|max:255',
            "signatories.*.company" => 'required|max:255',
            "signatories.*.email" => 'required|email',
        ]);

        $signatories = [];

        for($i = 1; $i <= $request->get('nb_signatories'); $i++) {
            $id = str_pad($i, 3, '0', STR_PAD_LEFT);

            $signatory = new Signatory($request->get('signatories')[$id]);

            $signatory->url_hash = uniqid('sign/');

            foreach(session('signatories_positions') as $sign_coord) {
                if($sign_coord->user_tag == $id) {
                    $signatory->sign_coord = json_encode($sign_coord);
                }
            }

            $signatories[] = $signatory;
        }

        session(['signatories' => $signatories]);

        return redirect('/invitation');
    }

    public function createInvitation(): View
    {
        $invitation = session('tags')['invitation'];
        $retry = session('tags')['retry'];

        return view('05-invitation', compact('invitation', 'retry'));
    }

    public function storeInvitation(Request $request)
    {
        $request->validate([
            "invitation_subject" => 'required|max:255',
            "invitation_description" => 'required|max:255',
            "invitation_quantity" => 'required|integer',
            "invitation_delay" => 'required|integer',
            "invitation_frequency" => 'required|integer',
        ]);

        $rds = session('rds');

        $rds->invitation_subject = $request->get('invitation_subject');
        $rds->invitation_description = $request->get('invitation_description');
        $rds->invitation_delay = $request->get('invitation_delay');
        $rds->invitation_frequency = $request->get('invitation_frequency');
        $rds->invitation_subject = $request->get('invitation_quantity');

        $rds->url_one_hash = uniqid('admin/');
        $rds->url_two_hash = uniqid('admin/');
        $rds->url_three_hash = uniqid('admin/');


        $rds_final = RDS::create($rds->getAttributes());

        $signatories = session('signatories');

        foreach($signatories as $signatory) {
            $rds_final->signatories()->save($signatory);
        }

        session(['rds_final' => $rds_final]);

        return redirect('/confirmation');
    }

    public function confirmation(): View
    {
        $rds = session('rds_final');
        return view('06-confirmation', compact('rds'));
    }

    private function downloadFile(Request $request): string
    {
        $file = $request->file('file');
        $downloadFile = Storage::disk('public')->put('pdf', $file);
        return Storage::disk('public')->url($downloadFile);
    }
}
