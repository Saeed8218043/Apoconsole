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
        Schema::create('orders_log', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('shop_url');
            $table->longText('order_json');
            $table->string('po_number', 225)->nullable()->unique('idx_orders_log_po_number');
            $table->float('sales_price', 10, 0)->default(0);
            $table->string('store', 225);
            $table->longText('vendor_json')->nullable();
            $table->integer('user_id')->default(0);
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
        Schema::dropIfExists('orders_log');
    }
};
