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
        Schema::create('tbl_planning', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_stock')->nullable();
            $table->integer('inventory_id');
            $table->string('Part_name')->nullable();
            $table->string('Part_number')->nullable();
            $table->integer('min');
            $table->integer('max');
            $table->timestamps();
        
            $table->foreign('id_stock')
                  ->references('id')
                  ->on('tbl_stock')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_planning');
    }
};
