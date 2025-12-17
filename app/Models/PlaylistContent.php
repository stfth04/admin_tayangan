<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlaylistContent extends Pivot
{
    use HasFactory;

    protected $table = 'playlist_content';

    protected $fillable = [
        'playlist_id',
        'content_id',
        'order',
        'duration',
    ];
}
