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
        Schema::create('pf_inventory', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('part_no');
            $table->string('sku', 225)->nullable()->index('index_sku');
            $table->integer('kit_id');
            $table->double('cost', 40, 2)->unsigned()->nullable()->default(0);
            $table->double('original_price');
            $table->double('fee', 40, 2)->unsigned()->nullable()->default(0);
            $table->double('commission', 40, 2)->unsigned()->nullable()->default(0);
            $table->double('shipping', 40, 2)->unsigned()->nullable()->default(0);
            $table->string('handling', 225)->default('0');
            $table->double('profit', 40, 2)->unsigned()->nullable()->default(0);
            $table->integer('qty')->nullable()->default(0);
            $table->integer('max_qty')->default(5);
            $table->integer('pricemasterrule')->default(1);
            $table->string('warehouse_name', 225);
            $table->integer('vendor')->default(1);
            $table->integer('found')->default(0);
            $table->integer('shopify_update')->default(1);
            $table->integer('location_inventory_id_check')->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pf_inventory');
    }
};
