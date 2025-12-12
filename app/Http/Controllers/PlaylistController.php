<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Playlist;
use App\Models\Content;
use App\Models\PlaylistContent; // WAJIB untuk pivot

class PlaylistController extends Controller
{
    // TAMPILKAN SEMUA PLAYLIST (WAJIB ADA)
    public function index()
    {
        $playlists = Playlist::orderBy('id', 'desc')->get();
        $konten = Content::orderBy('id', 'asc')->get();

        return view('admin.admin', compact('playlists', 'konten'));
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

    // TAMBAHKAN KONTEN KE PLAYLIST
    public function addContent(Request $request)
    {
        $playlist_id = $request->input('playlist_id');
        $content_id = $request->input('konten_id');

        if (!$playlist_id || !$content_id) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Playlist atau konten tidak ditemukan.']);
            }
            return back()->withErrors('Playlist atau konten tidak ditemukan.');
        }

        $playlist = Playlist::findOrFail($playlist_id);
        $playlist->contents()->syncWithoutDetaching([$content_id]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()
            ->with('success', 'Konten ditambahkan ke playlist.')
            ->with('show_tab', 'playlist');
    }


    // UPDATE NAMA PLAYLIST via AJAX
    public function updateName(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'nama_playlist' => 'required|string|max:255'
        ]);

        DB::table('playlists')
            ->where('id', $request->id)
            ->update([
                'nama_playlist' => $request->nama_playlist,
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'id' => $request->id,
            'nama_playlist' => $request->nama_playlist
        ]);
    }

    // HAPUS PLAYLIST
    public function destroy($id)
    {
        $playlist = DB::table('playlists')->where('id', $id)->first();

        if (!$playlist) {
            return response()->json([
                'success' => false,
                'message' => 'Playlist tidak ditemukan'
            ]);
        }

        DB::table('playlists')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Playlist berhasil dihapus'
        ]);
    }

    // DETAIL PLAYLIST UNTUK TAMPILAN BLADE
    public function show($id)
    {
        $playlist = Playlist::findOrFail($id);

        $contents = PlaylistContent::where('playlist_id', $id)
            ->orderBy('order', 'asc')
            ->get();

        return view('playlist.show', compact('playlist', 'contents'));
    }

    public function getContent($id)
{
    $playlist = Playlist::findOrFail($id);

    $konten = DB::table('playlist_content as pc')
        ->join('contents as c', 'pc.content_id', '=', 'c.id')
        ->where('pc.playlist_id', $id)
        ->orderBy('pc.`order`')            // hati-hati dengan reserved keyword
        ->select(
            'pc.id as pc_id',
            'pc.`order` as sort_order',    // alias aman
            'pc.duration',
            'c.file',
            'c.nama_file'
        )
        ->get();

    return response()->json([
        'playlist' => $playlist,
        'contents' => $konten
    ]);
}

}
