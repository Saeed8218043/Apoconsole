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
        Schema::create('trq', function (Blueprint $table) {
            $table->string('PartNumber')->primary();
            $table->string('Brand');
            $table->string('brand_abbr');
            $table->integer('stock');
            $table->double('price');
            $table->integer('expedite_eligibe');
            $table->integer('two_day_surcharge');
            $table->integer('overnight_surcharge');
            $table->string('map_price', 225)->nullable();
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
        Schema::dropIfExists('trq');
    }
};
