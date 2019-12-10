<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTileContentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tile_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en')->nullable();
            $table->string('name_pl')->nullable();
            $table->string('name_ru')->nullable();
            $table->string('type');
            $table->string('translation_key');
            $table->boolean('admin_visibility')->default(1);
            $table->boolean('user_visibility')->default(1);
            $table->unsignedBigInteger('tile_id');
            $table->timestamps();

            $table->foreign('tile_id')
                ->references('id')
                ->on('tiles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tile_contents');
    }
}
