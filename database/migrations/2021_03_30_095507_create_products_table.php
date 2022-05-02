<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->boolean('published')->default('0');
            $table->string('status');

            $table->boolean('size_35')->default('0');
            $table->boolean('size_36')->default('0');
            $table->boolean('size_37')->default('0');
            $table->boolean('size_38')->default('0');
            $table->boolean('size_39')->default('0');
            $table->boolean('size_40')->default('0');
            $table->boolean('size_41')->default('0');
            $table->boolean('size_42')->default('0');
            $table->boolean('size_43')->default('0');
            $table->boolean('size_44')->default('0');
            $table->boolean('size_45')->default('0');
            $table->boolean('size_46')->default('0');

            $table->json('title')->nullable();
            $table->json('h1')->nullable();

            $table->text('size_table')->nullable();

            $table->text('price')->nullable();
            $table->text('discount_price')->nullable();
            $table->integer('trade_price')->nullable();

            $table->json('description')->nullable();
            $table->json('content')->nullable();
            $table->json('characteristics')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('preview')->nullable();
            $table->integer('total_sales')->nullable();
            $table->integer('sort')->nullable()->unsigned();

            $table->integer('viewed')->nullable();
            $table->foreignId('provider_id')
                ->nullable()
                ->constrained('providers')
                ->references('id')
                ->onDelete('set null');

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
        Schema::dropIfExists('products');
    }
}
