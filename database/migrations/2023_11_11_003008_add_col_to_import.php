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
        Schema::table('imports', function (Blueprint $table) {
            $table->renameColumn('received', 'is_imported');
            $table->json('items')->after('name')->nullable();
            $table->char('type',20)->after('name')->default('supplier');
            $table->unsignedInteger('customer_id')->nullable()->after('name');
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imports', function (Blueprint $table) {
            $table->renameColumn('received', 'is_impoted');
            $table->dropColumn(['type','customer_id']);
        });
    }
};
