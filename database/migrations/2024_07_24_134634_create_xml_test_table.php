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
        Schema::create('xml_test', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('part_no');
            $table->string('from_year');
            $table->string('from_to');
            $table->string('make_id');
            $table->string('model_id');
            $table->longText('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xml_test');
    }
};
