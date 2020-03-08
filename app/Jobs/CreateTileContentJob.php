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

    private $tileContent,
        $input,
        $contents;

    /**
     * Create a new job instance.
     *
     * @param $tileContent
     * @param $input
     * @param $contents
     */
    public function __construct($tileContent, $input, $contents)
    {
        $this->tileContent = $tileContent;
        $this->input = $input;
        $this->contents = $contents;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Tile::where('shared_id', $this->input['tile_shared_id'])
                     ->where('id', '!=', $this->input['tile_id'])
                     ->get() as $tile) {
            $tileContent = new TileContent();
            $tileContent->shared_id = $this->tileContent->shared_id;
            $tileContent->name_pl = $this->tileContent->name_pl;
            $tileContent->name_en = $this->tileContent->name_en;
            $tileContent->name_ru = $this->tileContent->name_ru;
            $tileContent->type = $this->tileContent->type;
            $tileContent->translation_key = $this->tileContent->translation_key;
            $tileContent->position = $this->tileContent->position;
            $tileContent->tile_id = $tile->id;
            $tileContent->tile_shared_id = $tile->shared_id;
            $success = $tileContent->save();

            if ($success) {
                if (is_array($this->contents)) {
                    foreach ($this->contents as $contentLoop) {
                        $content = new Content();
                        $content->shared_id = $contentLoop['shared_id'];
                        $content->value_pl = $contentLoop['value_pl'];
                        $content->value_en = $contentLoop['value_en'];
                        $content->value_ru = $contentLoop['value_ru'];
                        $content->position = $contentLoop['position'];
                        $content->tile_content_id = $tileContent->id;
                        $content->tile_content_shared_id = $tileContent->shared_id;
                        $content->save();
                    }
                } else {
                    $content = new Content();
                    $content->shared_id = $this->contents->shared_id;
                    $content->value_pl = '';
                    $content->value_en = '';
                    $content->value_ru = '';
                    $content->position = $this->contents->position;
                    $content->tile_content_id = $tileContent->id;
                    $content->tile_content_shared_id = $tileContent->shared_id;
                    $content->save();
                }
            }
        }
    }
}
