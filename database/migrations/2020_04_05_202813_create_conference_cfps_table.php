<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferenceCfpsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('conference_cfps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file')->nullable();
            $table->string('content_pl')->nullable();
            $table->string('content_en')->nullable();
            $table->string('content_ru')->nullable();
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
        Schema::dropIfExists('conference_cfps');
    }
}
