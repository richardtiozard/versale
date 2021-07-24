<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');
            $table->string('message');

            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('buyer_id');

            $table->timestamps();

            $table->index('seller_id');
            $table->index('buyer_id');

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
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
        Schema::dropIfExists('buyer_ratings');
    }
}
