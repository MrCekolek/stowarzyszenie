<?php

namespace App\Models;

use App\Traits\ChangePosition;

class Tile extends BaseModel {
    use ChangePosition;

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

    public static function addTile($input, &$success) {
        $tile = new self();
        $tile->shared_id = self::where('portfolio_tab_shared_id', $input['portfolio_tab_shared_id'])->max('shared_id') + 1;
        $tile->name_pl = $input['name_pl'];
        $tile->name_en = $input['name_en'];
        $tile->name_ru = $input['name_ru'];
        $tile->position = self::where('portfolio_tab_shared_id', $input['portfolio_tab_shared_id'])->max('position') + 1;
        $tile->portfolio_tab_id = $input['portfolio_tab_id'];
        $tile->portfolio_tab_shared_id = $input['portfolio_tab_shared_id'];
        $success = $tile->save();

        return $tile;
    }

    public static function updateTile(&$tile, $input, &$success) {
        $tile->name_pl = $input['name_pl'];
        $tile->name_en = $input['name_en'];
        $tile->name_ru = $input['name_ru'];

        if ($tile->isDirty('position')) {
            self::changePosition(self::class, $tile, $input['position']);
        }

        $tile->admin_visibility = $input['admin_visibility'];
        $tile->user_visibility = $input['user_visibility'];
        $success &= $tile->save();
    }
}
