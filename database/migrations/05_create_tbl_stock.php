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
        Schema::create('tbl_stock', function (Blueprint $table) {
            $table->id();
            $table->string('Id_kbi')->nullable();
            $table->unsignedBigInteger('id_produksi');
            // $table->unsignedBigInteger('id_delivery')->nullable();
            $table->string('Part_name')->nullable();
            $table->string('Part_number')->nullable();
            $table->string('inventory_id');
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->integer('act_stock')->nullable();
            $table->enum('status',['danger','okey','over'])->nullable( );


            // fk
            $table->foreign('id_produksi')
                ->references('id')
                ->on('tbl_produksi')
                ->onDelete('cascade');



            // timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_stock');
    }
};
