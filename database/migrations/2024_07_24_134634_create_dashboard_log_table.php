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
        Schema::create('dashboard_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_csv_30days_chart', 500)->nullable();
            $table->string('order_csv_30days_chart_label', 500)->nullable();
            $table->string('order_shopify_30days_chart', 500)->nullable();
            $table->string('order_shopify_30days_chart_label', 500)->nullable();
            $table->string('order_shopify_30days_today', 500)->nullable();
            $table->string('order_shopify_30days', 500)->nullable();
            $table->string('order_csv_30days_today', 500)->nullable();
            $table->string('order_csv_30days', 500)->nullable();
            $table->string('total_purchase_value_today', 500)->nullable();
            $table->text('total_purchase_value')->nullable();
            $table->text('total_purchase_value_chart')->nullable();
            $table->string('today_success_orders', 500)->nullable();
            $table->string('today_failed_orders', 500)->nullable();
            $table->string('failed_orders_shopify', 500)->nullable();
            $table->string('failed_orders_csv', 500)->nullable();
            $table->string('last_shopify_update', 500)->nullable();
            $table->string('today_orders_shopify', 500)->nullable();
            $table->string('today_orders_csv', 500)->nullable();
            $table->string('total_products_synced', 500)->nullable();
            $table->timestamp('created_at')->nullable();
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
        Schema::dropIfExists('dashboard_log');
    }
};
