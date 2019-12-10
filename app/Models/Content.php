<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {
    protected $fillable = [
        'value',
        'selected',
        'admin_visibility',
        'user_visibility',
        'tile_content_id'
    ];

    public function tileContent() {
        return $this->belongsTo(TileContent::class);
    }
}
