<?php

namespace App\Models;

use App\Traits\ChangePosition;

class PortfolioTab extends BaseModel {
    use ChangePosition;

    protected $fillable = [
        'shared_id',
        'name_en',
        'name_pl',
        'name_ru',
        'position',
        'admin_visibility',
        'user_visibility',
        'portfolio_id'
    ];

    public static function portfolioTabs() {
        return [
            'Profile' => [
                'id' => 1,
                'shared_id' => 1,
                'position' => 1,
                'name' => 'Profile'
            ],
            'Interests' => [
                'id' => 2,
                'shared_id' => 2,
                'position' => 2,
                'name' => 'Interests'
            ]
        ];
    }

    public function portfolio() {
        return $this->belongsTo(Portfolio::class);
    }

    public function tiles() {
        return $this->hasMany(Tile::class);
    }

    public static function addPortfolioTab($input, &$success) {
        $portfolioTab = new self();
        $portfolioTab->shared_id = self::max('shared_id') + 1;
        $portfolioTab->name_pl = $input['name_pl'];
        $portfolioTab->name_en = $input['name_en'];
        $portfolioTab->name_ru = $input['name_ru'];
        $portfolioTab->position = self::max('position') + 1;
        $portfolioTab->portfolio_id = $input['portfolio_id'];
        $success = $portfolioTab->save();

        return $portfolioTab;
    }

    public static function updatePortfolioTab($portfolioTab, $input, &$success) {
        $portfolioTab->name_pl = $input['name_pl'];
        $portfolioTab->name_en = $input['name_en'];
        $portfolioTab->name_ru = $input['name_ru'];

        if ($portfolioTab->isDity('position')) {
            self::changePosition(self::class, $portfolioTab, $input['position']);
        }

        $portfolioTab->admin_visibility = $input['admin_visibility'];
        $portfolioTab->user_visibility = $input['user_visibility'];
        $success &= $portfolioTab->save();
    }
}
