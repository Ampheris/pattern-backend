<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('bikehistory_id')->nullable();
            $table->integer('total_price');
            $table->tinyInteger('subscription')->deafult(0)->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bikehistory_id')->references('id')->on('bikelogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
