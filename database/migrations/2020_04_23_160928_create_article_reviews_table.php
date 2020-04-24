<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleReviewsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('article_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mark')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->nullable();
            $table->string('translation_key')->nullable();
            $table->unsignedBigInteger('track_article_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('track_article_id')
                ->references('id')
                ->on('track_articles')
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
    public function down()
    {
        Schema::dropIfExists('article_reviews');
    }
}
