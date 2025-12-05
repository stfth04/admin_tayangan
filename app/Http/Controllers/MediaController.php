<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // tampilkan halaman upload
public function index()
{
    return view('admin.upload');
}



    // proses upload file
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4|max:51200', // max 50MB
            'tipe' => 'required|in:gambar,video',
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads', 'public');

        Media::create([
            'nama_file' => $file->getClientOriginalName(),
            'path' => $path,
            'tipe' => $request->tipe,
        ]);

        return back()->with('success', 'File berhasil diupload!');
    }
}
