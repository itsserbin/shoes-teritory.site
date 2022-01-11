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

            $table->boolean('xs')->nullable();
            $table->boolean('s')->default('0');
            $table->boolean('m')->default('0');
            $table->boolean('l')->default('0');
            $table->boolean('xl')->default('0');
            $table->boolean('xxl')->default('0');
            $table->boolean('xxxl')->default('0');

            $table->string('title')->nullable();
            $table->string('h1')->nullable();

            $table->text('size_table')->nullable();

            $table->text('price')->nullable();
            $table->text('discount_price')->nullable();
            $table->integer('trade_price')->nullable();

            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('characteristics')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('preview')->nullable();
            $table->integer('total_sales')->nullable();

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
