<?php

namespace App\Http\Controllers\googleDrive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    public function index()
    {
        return view('content.google-drive');
    }
    public function googleUploadFile(Request $request)
    {
        // return dd($request->all());
        $file = $request->file('myfile');
        $fname = $file->getClientOriginalName();
        $response = Storage::disk('google')->put($fname, File::get($file));
        return dd($response);
    }
}
