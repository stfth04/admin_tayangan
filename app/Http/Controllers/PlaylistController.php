<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\Content;

class PlaylistController extends Controller
{
    // TAMPILKAN SEMUA PLAYLIST (WAJIB ADA)
    public function index()
    {
        $playlists = Playlist::orderBy('id','desc')->get();
        $konten = Content::orderBy('id','asc')->get();

        return view('admin.admin', compact('playlists','konten'));
    }

    // SIMPAN PLAYLIST BARU
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required'
        ]);

        Playlist::create([
            'nama_playlist' => $request->judul
        ]);

        return back()
            ->with('success', 'Playlist berhasil dibuat!')
            ->with('show_tab', 'playlist');
    }

    // OPTIONAL (kalau nanti dipakai)
    public function show($id)
{
    $playlist = Playlist::findOrFail($id);

    // ambil semua konten dalam playlist
    $items = $playlist->contents()->get();

    return response()->json([
        'playlist' => $playlist,
        'items' => $items
    ]);
}


    // TAMBAHKAN KONTEN KE PLAYLIST
    public function addContent(Request $request)
    {
        $playlist_id = $request->playlist_id;
        $content_id = $request->content_id;

        $playlist = Playlist::findOrFail($playlist_id);
        $playlist->contents()->attach($content_id);

        return back()->with('success', 'Konten ditambahkan ke playlist.');
    }
}
