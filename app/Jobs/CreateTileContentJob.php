<?php

namespace App\Jobs;

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
        $tileSharedId;

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
     */
    public function __construct($shared_id, $name_pl, $name_en, $name_ru, $type, $translationKey, $position, $tileId, $tileSharedId)
    {
        $this->shared_id = $shared_id;
        $this->name_pl = $name_pl;
        $this->name_en = $name_en;
        $this->name_ru = $name_ru;
        $this->type = $type;
        $this->translationKey = $translationKey;
        $this->position = $position;
        $this->tileId = tileId;
        $this->tileSharedId = $tileSharedId;
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
            TileContent::create([
                'shared_id' => $this->shared_id,
                'name_pl' => $this->name_pl,
                'name_en' => $this->name_en,
                'name_ru' => $this->name_ru,
                'type' => $this->type,
                'translation_key' => $this->translationKey,
                'position' => $this->position,
                'tile_id' => $tile->id,
                'tile_shared_id' => $tile->shared_id
            ]);
        }
    }
}
