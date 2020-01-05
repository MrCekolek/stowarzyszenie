<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioTabsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('portfolio_tabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shared_id');
            $table->string('name_pl')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('admin_visibility')->default(1);
            $table->boolean('user_visibility')->default(1);
            $table->unsignedBigInteger('portfolio_id');
            $table->timestamps();

            $table->unique(['id', 'shared_id']);

            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolios')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('portfolio_tabs');
    }
}
