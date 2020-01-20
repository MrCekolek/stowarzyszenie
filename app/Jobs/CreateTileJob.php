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

    private $tile,
            $input;

    /**
     * Create a new job instance.
     *
     * @param $tile
     * @param $input
     */
    public function __construct($tile, $input)
    {
        $this->tile = $tile;
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (PortfolioTab::where('shared_id', $this->input['portfolio_tab_shared_id'])
                     ->where('id', '!=', $this->input['portfolio_tab_id'])
                     ->get() as $portfolioTab) {
            $tile = new Tile();
            $tile->shared_id = $this->tile->shared_id;
            $tile->name_pl = $this->tile->name_pl;
            $tile->name_en = $this->tile->name_en;
            $tile->name_ru = $this->tile->name_ru;
            $tile->position = $this->tile->position;
            $tile->portfolio_tab_id = $portfolioTab->id;
            $tile->portfolio_tab_shared_id = $portfolioTab->shared_id;
            $tile->save();
        }
    }
}
