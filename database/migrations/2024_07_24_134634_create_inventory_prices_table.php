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
        Schema::create('inventory_prices', function (Blueprint $table) {
            $table->bigInteger('id', true)->unique('id');
            $table->string('part_no', 225)->primary();
            $table->string('sku', 225)->nullable()->unique('unique_sku_index');
            $table->double('cost')->unsigned()->nullable();
            $table->integer('original_price');
            $table->double('fee')->unsigned()->nullable();
            $table->double('commission')->unsigned()->nullable();
            $table->double('shipping')->unsigned()->nullable();
            $table->double('profit')->unsigned()->nullable();
            $table->integer('qty')->nullable();
            $table->integer('max_qty')->default(5);
            $table->integer('pricemasterrule')->default(1);
            $table->integer('vendor')->default(1);
            $table->integer('found')->default(0);
            $table->integer('shopify_update')->default(1);
            $table->integer('location_inventory_id_check')->default(0);
            $table->float('mapped', 10, 0)->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_prices');
    }
};
