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

    private $shared_id,
            $name_pl,
            $name_en,
            $name_ru,
            $position,
            $userPortfolioId;

    /**
     * Create a new job instance.
     *
     * @param $shared_id
     * @param $name_pl
     * @param $name_en
     * @param $name_ru
     * @param $position
     * @param $userPortfolioId
     */
    public function __construct($shared_id, $name_pl, $name_en, $name_ru, $position, $userPortfolioId)
    {
        $this->shared_id = $shared_id;
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
        foreach (Portfolio::where('id', '!=', $this->userPortfolioId)->get() as $portfolio) {
            PortfolioTab::create([
                'shared_id' => $this->shared_id,
                'name_pl' => $this->name_pl,
                'name_en' => $this->name_en,
                'name_ru' => $this->name_ru,
                'position' => $this->position,
                'portfolio_id' => $portfolio->id
            ]);
        }
    }
}
