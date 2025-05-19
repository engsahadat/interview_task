<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function index()
    {
        return view('file-upload.index');
    }
    public function create()
    {
        return view('file-upload.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:6144', // max 6MB
        ]);
        $originalName = $request->file('file')->getClientOriginalName();
        $storedPath = $request->file('file')->storeAs('uploads', Str::random(10) . '_' . $originalName, 'public');
        ProcessUploadedFile::dispatch($storedPath);
        return response()->json([
            'success'  => true,
            'message'  => 'File uploaded and processing started.',
            'filename' => $storedPath,
            'redirect' => route('file.create')
        ]);
    }
}
