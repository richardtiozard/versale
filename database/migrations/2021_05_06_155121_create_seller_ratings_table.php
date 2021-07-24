<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');
            $table->string('message');

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('buyer_id');

            $table->timestamps();

            $table->index('product_id');
            $table->index('buyer_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_ratings');
    }
}
