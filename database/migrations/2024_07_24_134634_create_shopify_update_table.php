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
        Schema::create('shopify_update', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sku', 225)->unique('unique_sku_index');
            $table->string('vid');
            $table->string('shopify_price')->nullable();
            $table->string('shopify_qty')->nullable();
            $table->integer('updated')->default(0);
            $table->integer('error')->default(0);
            $table->string('troll')->nullable();
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
        Schema::dropIfExists('shopify_update');
    }
};
