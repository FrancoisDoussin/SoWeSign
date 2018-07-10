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

    public function createAdmin(Request $request): View
    {
        return view('create-admin');
    }

    public function context(Request $request): View
    {
        return view('context');
    }

    public function signatories(Request $request): View
    {
        return view('signatories');
    }

    public function invitation(Request $request): View
    {
        return view('invitation');
    }

    public function confirmation(Request $request): View
    {
        return view('confirmation');
    }

    private function downloadFile(Request $request): string
    {
        $file = $request->file('file');
        $downloadFile = Storage::disk('public')->put('pdf', $file);
        return Storage::disk('public')->url($downloadFile);
    }
}
