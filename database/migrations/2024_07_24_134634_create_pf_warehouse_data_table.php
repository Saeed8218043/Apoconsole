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
        Schema::create('pf_warehouse_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asin', 225);
            $table->string('part', 225);
            $table->string('picture', 225);
            $table->text('title');
            $table->string('tracking', 225);
            $table->double('price_per_unit')->default(0);
            $table->double('price')->default(0);
            $table->string('warehouse_name', 225)->default('Pfwarehouse');
            $table->string('status', 225);
            $table->double('average')->default(0);
            $table->integer('inventory_count');
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
        Schema::dropIfExists('pf_warehouse_data');
    }
};
