<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $source;
    protected $target;
    protected $expression;
    protected $model;
    protected $field;

    /**
     * Create a new job instance.
     *
     * @param $model
     * @param $field
     */
    public function __construct($source, $target, $expression, $model, $field) {
        $this->source = $source;
        $this->target = $target;
        $this->expression = $expression;
        $this->model = $model;
        $this->field = $field;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \ErrorException
     */
    public function handle() {
        $this->model->{$this->field} = GoogleTranslate::trans($this->expression, $this->target, $this->source);

        $this->model->save();
    }
}
