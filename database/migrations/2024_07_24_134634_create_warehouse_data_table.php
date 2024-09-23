<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('inMarket_Place')->nullable();
            $table->string('inOrder_ID')->nullable();
            $table->string('Tracking_ID')->nullable();
            $table->string('Customer_Name')->nullable();
            $table->string('Part')->nullable();
            $table->string('ASINItem_ID')->nullable();
            $table->string('Part_Condition')->nullable();
            $table->string('Picture')->nullable();
            $table->text('inlabel')->nullable();
            $table->text('outlabel')->nullable();
            $table->string('Ship_button')->nullable();
            $table->string('Shipping_Label')->nullable();
            $table->string('outMarket_Place')->nullable();
            $table->string('outOrder_ID')->nullable();
            $table->string('status', 225)->default('Stock In');
            $table->string('Shipped_Button')->nullable();
            $table->integer('admin')->nullable();
            $table->integer('userr')->nullable();
            $table->integer('user_id');
            $table->integer('warehouse_id');
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
        Schema::dropIfExists('warehouse_data');
    }
};
