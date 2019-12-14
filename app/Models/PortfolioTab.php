<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioTab extends Model {
    protected $fillable = [
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
                'position' => 0,
                'name' => 'Profile'
            ],
            'Interests' => [
                'id' => 2,
                'position' => 1,
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
}
