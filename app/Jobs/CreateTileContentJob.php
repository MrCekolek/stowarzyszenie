<?php

namespace App\Jobs;

use App\Models\Content;
use App\Models\Tile;
use App\Models\TileContent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateTileContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $shared_id,
        $name_pl,
        $name_en,
        $name_ru,
        $type,
        $translationKey,
        $position,
        $tileId,
        $tileSharedId,
        $content;

    /**
     * Create a new job instance.
     *
     * @param $shared_id
     * @param $name_pl
     * @param $name_en
     * @param $name_ru
     * @param $type
     * @param $translationKey
     * @param $position
     * @param $tileId
     * @param $tileSharedId
     * @param $content
     */
    public function __construct($shared_id, $name_pl, $name_en, $name_ru, $type, $translationKey, $position, $tileId, $tileSharedId, $content)
    {
        $this->shared_id = $shared_id;
        $this->name_pl = $name_pl;
        $this->name_en = $name_en;
        $this->name_ru = $name_ru;
        $this->type = $type;
        $this->translationKey = $translationKey;
        $this->position = $position;
        $this->tileId = $tileId;
        $this->tileSharedId = $tileSharedId;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Tile::where('shared_id', $this->tileSharedId)
                     ->where('id', '!=', $this->tileId)
                     ->get() as $tile) {
            $tileContent = new TileContent();
            $tileContent->shared_id = $this->shared_id;
            $tileContent->name_pl = $this->name_pl;
            $tileContent->name_en = $this->name_en;
            $tileContent->name_ru = $this->name_ru;
            $tileContent->type = $this->type;
            $tileContent->translation_key = $this->translationKey;
            $tileContent->position = $this->position;
            $tileContent->tile_id = $tile->id;
            $tileContent->tile_shared_id = $tile->shared_id;
            $success = $tileContent->save();

            if ($success) {
                $content = new Content();
                $content->shared_id = $this->content->shared_id;
                $content->value_pl = '';
                $content->value_en = '';
                $content->value_ru = '';
                $content->position = $this->content->position;
                $content->tile_content_id = $tileContent->id;
                $content->tile_content_shared_id = $tileContent->shared_id;
                $content->save();
            }
        }
    }
}
