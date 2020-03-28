<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConferenceUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('conference_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('conference_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('Nieopłacone');
            $table->timestamps();

            $table->unique(['conference_id', 'user_id']);

            $table->foreign('conference_id')
                ->references('id')
                ->on('conferences')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('conference_users');
    }
}
