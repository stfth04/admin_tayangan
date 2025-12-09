<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_playlist',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    // RELASI BENAR
    public function contents()
    {
        return $this->belongsToMany(
            Content::class,      // model tujuan
            'playlist_content',  // nama tabel pivot
            'playlist_id',       // fk di pivot
            'content_id'         // fk di pivot
        );
    }
}
