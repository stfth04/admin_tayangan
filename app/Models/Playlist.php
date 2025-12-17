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
            Content::class,
            'playlist_content',
            'playlist_id',
            'content_id'
        )
            ->using(PlaylistContent::class)
            ->withPivot(['order', 'duration'])
            ->orderByPivot('order');
    }

}
