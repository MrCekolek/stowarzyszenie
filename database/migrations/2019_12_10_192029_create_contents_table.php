<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shared_id');
            $table->text('value_pl')->nullable();
            $table->text('value_en')->nullable();
            $table->text('value_ru')->nullable();
            $table->text('filled_pl')->nullable();
            $table->text('filled_en')->nullable();
            $table->text('filled_ru')->nullable();
            $table->boolean('selected')->default(0);
            $table->integer('position')->default(0);
            $table->boolean('admin_visibility')->default(1);
            $table->boolean('user_visibility')->default(1);
            $table->unsignedBigInteger('tile_content_id');
            $table->unsignedBigInteger('tile_content_shared_id');
            $table->timestamps();

            $table->foreign('tile_content_id')
                ->references('id')
                ->on('tile_contents')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contents');
    }
}
