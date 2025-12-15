<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Playlist;
use App\Models\Content;
use App\Models\PlaylistContent; // WAJIB untuk pivot
use FFMpeg\FFProbe;

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
        try {
            $playlist_id = $request->playlist_id;
            $content_id = $request->konten_id;

            $playlist = Playlist::findOrFail($playlist_id);
            $content = Content::findOrFail($content_id);

            $duration = 0;
            $path = storage_path('app/public/' . $content->file);
            $ext = strtolower(pathinfo($content->file, PATHINFO_EXTENSION));

            if (in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm']) && file_exists($path)) {
                try {
                    $ffprobe = FFProbe::create([
                        'ffprobe.binaries' => config('services.ffmpeg.ffprobe'),
                        'ffmpeg.binaries' => config('services.ffmpeg.ffmpeg'),
                    ]);

                    $duration = (int) $ffprobe
                        ->format($path)
                        ->get('duration');

                } catch (\Throwable $e) {
                    // INI PENTING: jangan lempar error ke JS
                    \Log::error('FFProbe error', [
                        'message' => $e->getMessage(),
                        'path' => $path
                    ]);
                    $duration = 0;
                }
            }



            DB::table('playlist_content')->insert([
                'playlist_id' => $playlist_id,
                'content_id' => $content_id,
                'duration' => $duration,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Konten berhasil ditambahkan ke playlist'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
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
            ->select([
                'pc.id as pc_id',
                DB::raw('pc.`order` as sort_order'),
                'pc.duration',
                'c.file',
                'c.nama_file'
            ])
            ->orderByRaw('pc.`order` ASC')
            ->get();

        return response()->json([
            'playlist' => $playlist,
            'contents' => $konten
        ]);
    }
}
