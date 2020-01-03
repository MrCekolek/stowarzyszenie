<?php

namespace App\Jobs;

use App\Models\Portfolio;
use App\Models\PortfolioTab;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreatePortfolioTabsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $name_pl,
            $name_en,
            $name_ru,
            $position,
            $userPortfolioId;

    /**
     * Create a new job instance.
     *
     * @param $name_pl
     * @param $name_en
     * @param $name_ru
     * @param $position
     * @param $userPortfolioId
     */
    public function __construct($name_pl, $name_en, $name_ru, $position, $userPortfolioId)
    {
        $this->name_pl = $name_pl;
        $this->name_en = $name_en;
        $this->name_ru = $name_ru;
        $this->position = $position;
        $this->userPortfolioId = $userPortfolioId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Portfolio::where('id', '!=', $this->userPortfolioId) as $portfolio) {
            PortfolioTab::create([
                'name_pl' => $this->name_pl,
                'name_en' => $this->name_en,
                'name_ru' => $this->name_ru,
                'position' => $this->position,
                'portfolio_id' => $portfolio->id
            ]);
        }
    }
}
