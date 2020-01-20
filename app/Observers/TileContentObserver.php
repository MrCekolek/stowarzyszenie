<?php

namespace App\Observers;

use App\Models\Content;
use App\Models\TileContent;

class TileContentObserver {
    /**
     * Handle the role "created" event.
     *
     * @param TileContent $tileContent
     * @return void
     */
    public function created(TileContent $tileContent) {
        

        $content = new Content();
        $content->shared_id = Content::max('shared_id') + 1;
        $content->value_pl = '';
        $content->value_en = '';
        $content->value_ru = '';
        $content->tile_content_id = $tileContent->id;
        $content->tile_content_shared_id = $tileContent->shared_id;
        $content->save();
    }
}
