<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConferencesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('conferences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->default('waiting');
            $table->string('translation_key');
            $table->string('acronym')->nullable();
            $table->string('name_pl')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();
            $table->text('content_pl')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_ru')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('conferences');
    }
}
