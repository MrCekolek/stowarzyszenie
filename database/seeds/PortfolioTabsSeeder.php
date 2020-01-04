<?php

use App\Models\Portfolio;
use App\Models\PortfolioTab;
use App\Traits\Translatable;
use Illuminate\Database\Seeder;

class PortfolioTabsSeeder extends Seeder {
    use Translatable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        foreach (PortfolioTab::portfolioTabs() as $portfolioTab) {
            foreach (Portfolio::all() as $portfolio) {
                $this->translate(
                    'en',
                    $portfolioTab['name'],
                    factory(PortfolioTab::class)->create([
                        'shared_id' => $portfolioTab['shared_id'],
                        'position' => $portfolioTab['position'],
                        'portfolio_id' => $portfolio->id
                    ]),
                    'name'
                );
            }
        }
    }
}
