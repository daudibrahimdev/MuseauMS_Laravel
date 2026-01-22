<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('shipments', function (Blueprint $table) {
            // Mengubah kolom menjadi nullable agar bisa dikosongkan saat awal checkout
            $table->string('courier_name')->nullable()->change();
            $table->string('tracking_code')->nullable()->change();
            $table->date('estimated_arrival')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('courier_name')->nullable(false)->change();
            $table->string('tracking_code')->nullable(false)->change();
            $table->date('estimated_arrival')->nullable(false)->change();
        });
    }
};
