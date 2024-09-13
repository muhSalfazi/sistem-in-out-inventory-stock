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
        Schema::create('tbl_produksi', function (Blueprint $table) {
            $table->id();
            $table->string('Id_kbi')->nullable();
            $table->string('Part_number')->nullable();
            $table->string('Part_name')->nullable();
            $table->string('Wo_no')->nullable();
            $table->string('inventory_id');
            $table->string('job_no')->nullable();
            $table->string('line')->nullable();
            $table->integer('Qty');
            $table->dateTime('waktu')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_produksi');
    }
};
