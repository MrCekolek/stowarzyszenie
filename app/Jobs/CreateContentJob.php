<?php

namespace App\Jobs;

use App\Models\Content;
use App\Models\TileContent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $shared_id,
        $name_pl,
        $name_en,
        $name_ru,
        $position,
        $tileContentId,
        $tileContentSharedId;

    /**
     * Create a new job instance.
     *
     * @param $shared_id
     * @param $name_pl
     * @param $name_en
     * @param $name_ru
     * @param $position
     * @param $tileContentId
     * @param $tileContentSharedId
     */
    public function __construct($shared_id, $name_pl, $name_en, $name_ru, $position, $tileContentId, $tileContentSharedId)
    {
        $this->shared_id = $shared_id;
        $this->name_pl = $name_pl;
        $this->name_en = $name_en;
        $this->name_ru = $name_ru;
        $this->position = $position;
        $this->tileContentId = $tileContentId;
        $this->tileContentSharedId = $tileContentSharedId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (TileContent::where('shared_id', $this->tileContentSharedId)
                     ->where('id', '!=', $this->tileContentId)
                     ->get() as $tileContent) {
            Content::create([
                'shared_id' => $this->shared_id,
                'name_pl' => $this->name_pl,
                'name_en' => $this->name_en,
                'name_ru' => $this->name_ru,
                'position' => $this->position,
                'tile_content_id' => $tileContent->id,
                'tile_content_shared_id' => $tileContent->shared_id
            ]);
        }
    }
}
