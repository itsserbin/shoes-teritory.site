<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->json('title');
            $table->string('slug')->unique();
            $table->string('preview')->nullable();
            $table->integer('parent_id')->nullable();
            $table->tinyInteger('published')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('modified_by')->nullable();
            $table->integer('sort')->nullable()->unsigned();

            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->json('meta_keyword')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
