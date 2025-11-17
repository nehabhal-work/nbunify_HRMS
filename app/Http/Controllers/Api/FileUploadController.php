<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class FileUploadController extends Controller
{
    public function uploadToTempStorage(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('temp', $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $path),
            'path' => $path,
            'filename' => $filename
        ]);
    }
}
