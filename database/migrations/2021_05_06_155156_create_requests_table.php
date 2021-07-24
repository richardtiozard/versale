<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->double('budget',8,2);
            $table->unsignedInteger('quantity');
            $table->string('title');
            $table->text('description');
            $table->string('status')->default('Available');

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('buyer_id');

            $table->timestamps();

            $table->index('category_id');
            $table->index('buyer_id');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('requests');
    }
}
