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
        Schema::create('shopify_product_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('v_id')->nullable();
            $table->text('p_id')->nullable();
            $table->text('sku')->nullable();
            $table->double('price')->nullable();
            $table->text('quantity')->nullable();
            $table->text('inventory_item_id')->nullable();
            $table->text('location_id')->nullable();
            $table->text('inventory_quantity')->nullable();
            $table->text('available_adjustment')->nullable();
            $table->double('net_price')->nullable();
            $table->integer('qty')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopify_product_details');
    }
};
