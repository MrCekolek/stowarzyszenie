<?php

namespace App\Models;

class Portfolio extends BaseModel {
    protected $fillable = [
        'description',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function portfolioTabs() {
        return $this->hasMany(PortfolioTab::class);
    }
}
