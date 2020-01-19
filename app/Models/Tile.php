<?php

namespace App\Models;

class Tile extends BaseModel {
    protected $fillable = [
        'shared_id',
        'name_pl',
        'name_en',
        'name_ru',
        'position',
        'admin_visibility',
        'user_visibility',
        'portfolio_tab_id',
        'portfolio_tab_shared_id'
    ];

    public function portfolioTab() {
        return $this->belongsTo(PortfolioTab::class);
    }

    public function tileContents() {
        return $this->hasMany(TileContent::class);
    }
}
