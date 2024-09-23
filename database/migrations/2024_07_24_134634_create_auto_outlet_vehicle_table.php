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
        Schema::create('auto_outlet_vehicle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('PartNumber');
            $table->string('Year');
            $table->string('Make');
            $table->string('Model');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_outlet_vehicle');
    }
};
