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

    private $content,
            $input;

    /**
     * Create a new job instance.
     *
     * @param $content
     * @param $input
     */
    public function __construct($content, $input)
    {
        $this->content = $content;
        $this->input = $input;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (TileContent::where('shared_id', $this->input['tile_content_shared_id'])
                     ->where('id', '!=', $this->input['tile_content_id'])
                     ->get() as $tileContent) {
            Content::create([
                'shared_id' => $this->content->shared_id,
                'name_pl' => $this->content->name_pl,
                'name_en' => $this->content->name_en,
                'name_ru' => $this->content->name_ru,
                'position' => $this->content->position,
                'tile_content_id' => $tileContent->id,
                'tile_content_shared_id' => $tileContent->shared_id
            ]);
        }
    }
}
