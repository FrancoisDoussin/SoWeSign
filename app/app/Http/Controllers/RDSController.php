<?php

namespace App\Http\Controllers;

use App\Models\RDS;
use App\Models\Signatory;
use App\Repositories\RDSRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

            $signatory->url_hash = uniqid();

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
        $rds->invitation_quantity = $request->get('invitation_quantity');

        $rds->url_one_hash = uniqid();
        $rds->url_two_hash = uniqid();
        $rds->url_three_hash = uniqid();


        $rds_final = RDS::create($rds->getAttributes());

        $signatories = session('signatories');

        foreach($signatories as $signatory) {
            $rds_final->signatories()->save($signatory);
        }

        return redirect('/manage/' . $rds_final->url_one_hash);
    }

    public function manage(Request $request, $hash)
    {
        $rds = RDS::where('url_one_hash', '=', $hash)->get()->first();

        if(!$rds) {
            return redirect('/error')->with('error', "This RDS does'nt exist");
        }

        return view('06-manage', compact('rds'));
    }

    public function state(Request $request, $hash)
    {
        $rds = RDS::where('url_two_hash', '=', $hash)->get()->first();

        if(!$rds) {
            return redirect('/error')->with('error', "This RDS does'nt exist");
        }

        return view('state', compact('rds'));
    }

    public function download(Request $request, $hash)
    {
        $rds = RDS::where('url_three_hash', '=', $hash)->get()->first();

        if(!$rds) {
            return redirect('/error')->with('error', "This RDS does'nt exist");
        }

        // get pdf path, get the signed version if exists
        if (file_exists(storage_path('app/public/pdf/signed/' . $rds->file_name . '.pdf'))) {
            $file_path = public_path(). '/storage/pdf/signed/' . $rds->file_name . '.pdf';
        } else {
            $file_path = public_path() . '/storage/pdf/' . $rds->file_name . '.pdf';
        }

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response()->download($file_path, 'document.pdf', $headers);
    }
}
