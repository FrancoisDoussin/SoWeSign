<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SignatoryController extends Controller
{
    public function sign(Request $request, $hash)
    {
        // get signatory
        $signatory = Signatory::where('url_hash', '=', 'sign/' . $hash)->get()->first();

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
            $file_path = $request->file('sign')->store('public/sign');

            $signatory = Signatory::find($request->get('signatory_id'));

            $signatory->sign_path = $file_path;
            $signatory->has_signed = 1;
            $signatory->save();

            return 'success';
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
