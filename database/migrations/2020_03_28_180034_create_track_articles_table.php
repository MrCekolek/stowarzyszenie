<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackArticlesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('track_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_pl')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ru')->nullable();
            $table->longText('abstract_pl')->nullable();
            $table->longText('abstract_en')->nullable();
            $table->longText('abstract_ru')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file')->nullable();
            $table->string('status');
            $table->string('keywords_pl')->nullable();
            $table->string('keywords_en')->nullable();
            $table->string('keywords_ru')->nullable();
            $table->string('translation_key');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('track_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('track_articles');
    }
}
