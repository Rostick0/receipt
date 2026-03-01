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
        Schema::create('amounts_receipt_nds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
            $table->integer('nds');
            $table->integer('ndsSum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amounts_receipt_nds');
    }
};
