<?php

namespace App\Jobs;

use App\Models\PortfolioTab;
use App\Models\Tile;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateTileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $shared_id,
        $name_pl,
        $name_en,
        $name_ru,
        $position,
        $portfolioTabId,
        $portfolioTabSharedId;

    /**
     * Create a new job instance.
     *
     * @param $shared_id
     * @param $name_pl
     * @param $name_en
     * @param $name_ru
     * @param $position
     * @param $portfolioTabId
     * @param $portfolioTabSharedId
     */
    public function __construct($shared_id, $name_pl, $name_en, $name_ru, $position, $portfolioTabId, $portfolioTabSharedId)
    {
        $this->shared_id = $shared_id;
        $this->name_pl = $name_pl;
        $this->name_en = $name_en;
        $this->name_ru = $name_ru;
        $this->position = $position;
        $this->portfolioTabId = $portfolioTabId;
        $this->portfolioTabSharedId = $portfolioTabSharedId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (PortfolioTab::where('shared_id', $this->portfolioTabSharedId)
                     ->where('id', '!=', $this->portfolioTabId)
                     ->get() as $portfolioTab) {
            Tile::create([
                'shared_id' => $this->shared_id,
                'name_pl' => $this->name_pl,
                'name_en' => $this->name_en,
                'name_ru' => $this->name_ru,
                'position' => $this->position,
                'portfolio_tab_id' => $portfolioTab->id,
                'portfolio_tab_shared_id' => $portfolioTab->shared_id
            ]);
        }
    }
}
