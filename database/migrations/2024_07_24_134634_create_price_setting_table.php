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
        Schema::create('price_setting', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('vendor_name', 225);
            $table->double('fee');
            $table->double('commission');
            $table->double('shipping');
            $table->integer('price_percentage');
            $table->double('profit');
            $table->integer('quantity');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_setting');
    }
};
