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
        Schema::create('pf', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('SKU')->index('sku_index');
            $table->string('PARTSLINK', 225)->nullable()->index('unique_partslink_index');
            $table->string('OEM_NUMBER', 225)->nullable()->index('unique_OEM_NUMBER_index');
            $table->string('PRICE');
            $table->string('shipping_fee', 225)->default('0');
            $table->string('handling', 225)->default('0');
            $table->string('QTY');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pf');
    }
};
