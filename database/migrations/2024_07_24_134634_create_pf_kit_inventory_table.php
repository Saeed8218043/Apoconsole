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
        Schema::create('pf_kit_inventory', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sku');
            $table->double('price', 40, 2);
            $table->integer('inventory');
            $table->string('warehouse_name', 225);
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
        Schema::dropIfExists('pf_kit_inventory');
    }
};
