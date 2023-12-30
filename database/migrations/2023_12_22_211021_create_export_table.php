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
        Schema::create('exports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->json('items');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('inventory_id')->nullable();
            $table->string('export_status')->default('open')->comment('Open-Released-Shipped-Completed');
            $table->date('export_date')->default(now());
            $table->string('delivery_address')->nullable();
            $table->string('reciever_name')->nullable();
            $table->string('reciever_phone')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('driver_plate')->nullable();
            $table->text('note');
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
            $table->foreign('project_id')->references('id')->on('projects')->nullOnDelete();
            $table->foreign('inventory_id')->references('id')->on('inventories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exports');
    }
};
