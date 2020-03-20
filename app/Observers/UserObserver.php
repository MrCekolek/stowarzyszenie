<?php

namespace App\Observers;

use App\Models\Content;
use App\Models\Portfolio;
use App\Models\PortfolioTab;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Tile;
use App\Models\TileContent;
use App\Models\User;

class UserObserver {
    /**
     * Handle the role "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user) {
        factory(RoleUser::class)->create([
            'role_id' => $user->id === 1 ?
                Role::where('name_pl', 'Administrator')->first()->id :
                Role::where('name_pl', 'Użytkownik')->first()->id,
            'user_id' => $user->id
        ]);

        $portfolio = factory(Portfolio::class)->create([
            'user_id' => $user->id
        ]);

        foreach (PortfolioTab::where('portfolio_id', 1)->get() as $portfolioTabFor) {
            $portfolioTab = new PortfolioTab();
            $portfolioTab->shared_id = $portfolioTabFor->shared_id;
            $portfolioTab->name_pl = $portfolioTabFor->name_pl;
            $portfolioTab->name_en = $portfolioTabFor->name_en;
            $portfolioTab->name_ru = $portfolioTabFor->name_ru;
            $portfolioTab->position = $portfolioTabFor->position;
            $portfolioTab->admin_visibility = $portfolioTabFor->admin_visibility;
            $portfolioTab->user_visibility = 1;
            $portfolioTab->portfolio_id = $portfolio->id;
            $portfolioTab->save();
            
            foreach ($portfolioTabFor->tiles()->get() as $tileFor) {
                $tile = new Tile();
                $tile->shared_id = $tileFor->shared_id;
                $tile->name_pl = $tileFor->name_pl;
                $tile->name_en = $tileFor->name_en;
                $tile->name_ru = $tileFor->name_ru;
                $tile->position = $tileFor->position;
                $tile->admin_visibility = $tileFor->admin_visibility;
                $tile->user_visibility = 1;
                $tile->portfolio_tab_id = $portfolioTab->id;
                $tile->portfolio_tab_shared_id = $portfolioTab->shared_id;
                $tile->save();

                foreach ($tileFor->tileContents()->get() as $tileContentFor) {
                    $tileContent = new TileContent();
                    $tileContent->shared_id = $tileContentFor->shared_id;
                    $tileContent->name_pl = $tileContentFor->name_pl;
                    $tileContent->name_en = $tileContentFor->name_en;
                    $tileContent->name_ru = $tileContentFor->name_ru;
                    $tileContent->type = $tileContentFor->type;
                    $tileContent->translation_key = $tileContentFor->translation_key;
                    $tileContent->position = $tileContentFor->position;
                    $tileContent->admin_visibility = $tileContentFor->admin_visibility;
                    $tileContent->user_visibility = 1;
                    $tileContent->tile_id = $tile->id;
                    $tileContent->tile_shared_id = $tile->shared_id;
                    $tileContent->save();

                    foreach ($tileContentFor->contents()->get() as $contentFor) {
                        $content = new Content();
                        $content->shared_id = $contentFor->shared_id;
                        $content->value_pl = $contentFor->value_pl;
                        $content->value_en = $contentFor->value_en;
                        $content->value_ru = $contentFor->value_ru;
                        $content->filled_pl = '';
                        $content->filled_en = '';
                        $content->filled_ru = '';
                        $content->selected = 0;
                        $content->position = $contentFor->position;
                        $content->admin_visibility = $contentFor->admin_visibility;
                        $content->user_visibility = 1;
                        $content->tile_content_id = $tileContent->id;
                        $content->tile_content_shared_id = $tileContent->shared_id;
                        $content->save();
                    }
                }
            }
        }
    }
}
