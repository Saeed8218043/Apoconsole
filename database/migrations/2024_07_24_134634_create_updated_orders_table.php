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
        Schema::create('updated_orders', function (Blueprint $table) {
            $table->integer('updated_orders', true);
            $table->string('po_number', 225)->unique('idx_updated_orders_po_number');
            $table->string('tracking', 225)->nullable();
            $table->longText('vendor_json');
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
        Schema::dropIfExists('updated_orders');
    }
};
