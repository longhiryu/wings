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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('consignee_name')->nullable()->after('staff_id');
            $table->string('consignee_phone')->nullable()->after('consignee_name');
            $table->string('address')->nullable()->after('consignee_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIfExists('consignee_name');
            $table->dropIfExists('consignee_phone');
            $table->dropIfExists('address');
        });
    }
};
