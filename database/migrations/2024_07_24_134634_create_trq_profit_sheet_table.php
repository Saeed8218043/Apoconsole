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
        Schema::create('trq_profit_sheet', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('po_number', 225)->nullable()->unique('unique_ponumber');
            $table->string('shipper_name', 225);
            $table->string('order_date', 225);
            $table->string('store', 225);
            $table->double('selling_fees');
            $table->double('selling_fees_reverse');
            $table->double('net_selling_fee');
            $table->double('trq_rtn');
            $table->double('net_cost');
            $table->double('adjustment_fee');
            $table->double('shipping_fee');
            $table->double('shipping_fee_reversal');
            $table->double('net_shipping_fee');
            $table->double('rep/refund');
            $table->double('cogs');
            $table->double('total_cost');
            $table->double('revenue_passive');
            $table->double('odr');
            $table->double('sale_price');
            $table->double('amazon_fee');
            $table->double('cost_of_product');
            $table->double('profit');
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
        Schema::dropIfExists('trq_profit_sheet');
    }
};
