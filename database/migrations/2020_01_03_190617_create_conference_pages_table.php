<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConferencePagesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('conference_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->string('translation_key');
            $table->string('name_pl')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();
            $table->text('content_pl')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_ru')->nullable();
            $table->unsignedBigInteger('conference_id');
            $table->timestamps();

            $table->foreign('conference_id')
                ->references('id')
                ->on('conferences')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('conference_pages');
    }
}
