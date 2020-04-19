<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferenceEventsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('conference_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_pl')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();
            $table->timestamp('datetime')->nullable();
            $table->timestamp('end')->nullable();
            $table->string('calendar')->default(0);
            $table->string('colour')->nullable();
            $table->text('description_pl')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ru')->nullable();
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
        Schema::dropIfExists('conference_events');
    }
}
