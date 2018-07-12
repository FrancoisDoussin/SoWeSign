<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use App\Repositories\RDSRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SignatoryController extends Controller
{
    private $rdsRepository;

    public function __construct(RDSRepository $rdsRepository)
    {
        $this->rdsRepository = $rdsRepository;
    }

    public function sign(Request $request, $hash)
    {
        // get signatory
        $signatory = Signatory::where('url_hash', '=', $hash)->get()->first();

        if(!$signatory) {
            return redirect('/error')->with('error', 'No signatories detected');
        }

        if($signatory->has_signed) {
            return redirect('/error')->with('error', 'You have already sign');
        }

        return view('sign', compact('signatory'));
    }

    public function upload(Request $request) {
        try {
            // get sign and store it
            $file_path = $request->file('sign')->store('public/sign');

            // clean path
            $file_name = str_replace('public/sign/', '', $file_path);

            // get signatory
            $signatory = Signatory::find($request->get('signatory_id'));

            // update signatory
            $signatory->sign_name = $file_name;
            $signatory->has_signed = 1;

            // add sign to pdf
            $addSign = $this->rdsRepository->addSign($signatory);

            // persist signatory changes if success
            if ($addSign == 'success') {
                $signatory->save();
            }

            return $addSign;
        }
        catch (\Exception $e) {
            Log::debug($e->getMessage());
            return 'error';
        }
    }

    public function signSuccess() {
        return view('sign-success');
    }
}
