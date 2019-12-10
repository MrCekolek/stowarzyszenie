<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('interest_users', function (Blueprint $table) {
            $table->unsignedBigInteger('interest_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->unique(['interest_id', 'user_id']);
            $table->foreign('interest_id')
                ->references('id')
                ->on('interests')
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
        Schema::dropIfExists('interest_users');
    }
}
