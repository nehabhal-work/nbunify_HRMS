<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TempUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $path = $request->file('file')->store('temp-uploads', 'public');

        return response()->json([
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}