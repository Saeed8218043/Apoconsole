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
        Schema::create('auto_outlet_csv', function (Blueprint $table) {
            $table->unsignedBigInteger('tid')->primary();
            $table->string('ExtractRunId')->nullable();
            $table->string('PartNumber')->nullable();
            $table->string('BasePartNumber')->nullable();
            $table->string('CorePartNumber')->nullable();
            $table->string('ProductLine')->nullable();
            $table->string('SequenceNumber')->nullable();
            $table->string('SubProductLine')->nullable();
            $table->string('ImagePath')->nullable();
            $table->string('WebDescription1')->nullable();
            $table->string('WebDescription2')->nullable();
            $table->string('WebDescription3')->nullable();
            $table->string('FrenchDescription1')->nullable();
            $table->string('FrenchDescription2')->nullable();
            $table->string('DefaultUnitOfMeasure')->nullable();
            $table->string('SecurityCode')->nullable();
            $table->string('SoldOnWeb')->nullable();
            $table->string('PlatinumPlus')->nullable();
            $table->string('Capa')->nullable();
            $table->string('KeyTrac')->nullable();
            $table->string('C2COnWeb')->nullable();
            $table->string('OverSize')->nullable();
            $table->string('ValueLine')->nullable();
            $table->string('NSF')->nullable();
            $table->string('Weight')->nullable();
            $table->integer('ListPrice')->nullable();
            $table->string('CustomerPrice')->nullable();
            $table->string('QuantityAvailable')->nullable();
            $table->string('DateCreated')->nullable();
            $table->string('Length')->nullable();
            $table->string('Width')->nullable();
            $table->string('Depth')->nullable();
            $table->string('HighRisk')->nullable();
            $table->string('Reman')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_outlet_csv');
    }
};
