<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_delivery', function (Blueprint $table) {
            $table->id();
            $table->integer('manifest_no');
            $table->string('job_no_custumer');
            $table->string('inventory_id_kbi');
            $table->dateTime('scandate')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_delivery');
    }
};
