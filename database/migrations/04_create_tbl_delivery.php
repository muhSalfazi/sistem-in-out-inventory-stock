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
            $table->unsignedBigInteger('id_stock');
            $table->string('job_no_customer')->nullable();
            $table->string('inventory_id_kbi')->nullable();
            $table->dateTime('scandate')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();

            // fk_delivery
            $table->foreign('id_stock')
            ->references('id')
            ->on('tbl_stock')
            ->onDelete('cascade');
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
