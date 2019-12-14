<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tile extends Model {
    protected $fillable = [
        'name_en',
        'name_pl',
        'name_ru',
        'position',
        'admin_visibility',
        'user_visibility',
        'portfolio_tab_id'
    ];

    public function portfolioTab() {
        return $this->belongsTo(PortfolioTab::class);
    }

    public function tileContents() {
        return $this->hasMany(TileContent::class);
    }
}
