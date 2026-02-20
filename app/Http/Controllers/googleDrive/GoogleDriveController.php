<?php

namespace App\Http\Controllers\googleDrive;

use App\Http\Controllers\Controller;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class GoogleDriveController extends Controller
{
    public function __construct(
        public GoogleDriveService $googleDriveService
    ) {
        config(['filesystems.disks.google.accessToken' => $this->googleDriveService->getAccessToken()]);
    }


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
        // Gdrive::put($fname, $file);

        $response = Gdrive::all('/');
        return dd($response);
    }
}
