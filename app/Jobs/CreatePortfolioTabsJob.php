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

    private $portfolioTab,
            $input;

    /**
     * Create a new job instance.
     *
     * @param $portfolioTab
     * @param $input
     */
    public function __construct($portfolioTab, $input)
    {
        $this->portfolioTab = $portfolioTab;
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Portfolio::where('id', '!=', $this->input['portfolio_id'])->get() as $portfolio) {
            PortfolioTab::create([
                'shared_id' => $this->portfolioTab->shared_id,
                'name_pl' => $this->portfolioTab->name_pl,
                'name_en' => $this->portfolioTab->name_en,
                'name_ru' => $this->portfolioTab->name_ru,
                'position' => $this->portfolioTab->position,
                'portfolio_id' => $portfolio->id
            ]);
        }
    }
}
