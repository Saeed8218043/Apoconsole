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
        Schema::create('essandanteve_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id', 225);
            $table->string('ship_by_date', 225);
            $table->string('label_price', 225);
            $table->string('label', 225);
            $table->string('asin', 225);
            $table->string('part', 225);
            $table->string('picture', 225);
            $table->string('tracking', 225);
            $table->string('status', 225);
            $table->integer('ordered_items');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('essandanteve_orders');
    }
};
