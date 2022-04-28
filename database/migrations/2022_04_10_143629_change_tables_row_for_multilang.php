<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTablesRowForMultilang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText('title')->nullable()->change();
            $table->longText('h1')->nullable()->change();
            $table->longText('description')->nullable()->change();
            $table->longText('content')->nullable()->change();
            $table->longText('characteristics')->nullable()->change();
        });

        $products = \App\Models\Products::all();
        foreach ($products as $product) {
            $product->title = ['ua' => null, 'ru' => $product->title];
            $product->h1 = ['ua' => null, 'ru' => $product->h1];
            $product->description = ['ua' => null, 'ru' => $product->description];
            $product->content = ['ua' => null, 'ru' => $product->content];
            $product->characteristics = ['ua' => null, 'ru' => $product->characteristics];
            $product->update();
        }
        Schema::table('products', function (Blueprint $table) {
            $table->json('title')->nullable()->change();
            $table->json('h1')->nullable()->change();
            $table->json('description')->nullable()->change();
            $table->json('content')->nullable()->change();
            $table->json('characteristics')->nullable()->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->longText('title')->nullable()->change();
            $table->longText('meta_title')->nullable()->change();
            $table->longText('meta_description')->nullable()->change();
            $table->longText('meta_keyword')->nullable()->change();
            $table->boolean('published')->default(0)->change();
        });

        $categories = \App\Models\Categories::all();
        foreach ($categories as $category) {
            $category->title = ['ua' => null, 'ru' => $category->title];
            $category->meta_title = ['ua' => null, 'ru' => $category->meta_title];
            $category->meta_description = ['ua' => null, 'ru' => $category->meta_description];
            $category->meta_keyword = ['ua' => null, 'ru' => $category->meta_keyword];
            $category->update();
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->json('title')->nullable()->change();
            $table->json('meta_title')->nullable()->change();
            $table->json('meta_description')->nullable()->change();
            $table->json('meta_keyword')->nullable()->change();
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->longText('title')->nullable()->change();
            $table->longText('image')->nullable()->change();
            $table->longText('link')->nullable()->change();
        });

        $banners = \App\Models\Banner::all();
        foreach ($banners as $banner) {
            $banner->title = ['ua' => null, 'ru' => $banner->title];
            $banner->image = ['ua' => null, 'ru' => $banner->image];
            $banner->link = ['ua' => null, 'ru' => $banner->link];
            $banner->update();
        }

        Schema::table('banners', function (Blueprint $table) {
            $table->json('title')->nullable()->change();
            $table->json('image')->nullable()->change();
            $table->json('link')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
