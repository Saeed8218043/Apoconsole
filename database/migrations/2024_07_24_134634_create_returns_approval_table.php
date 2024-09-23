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
        Schema::create('returns_approval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id', 225);
            $table->string('part', 225);
            $table->string('part_status', 225)->default('Pending');
            $table->string('picture', 225);
            $table->string('title', 225);
            $table->string('tracking', 225);
            $table->string('warehouse_name', 225)->default('Pfwarehouse');
            $table->string('status', 225);
            $table->integer('returned_count');
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
        Schema::dropIfExists('returns_approval');
    }
};
