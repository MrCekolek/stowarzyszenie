<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {
    protected $fillable = [
        'shared_id',
        'value',
        'selected',
        'position',
        'admin_visibility',
        'user_visibility',
        'tile_content_id',
        'tile_content_shared_id'
    ];

    public function tileContent() {
        return $this->belongsTo(TileContent::class);
    }
}
