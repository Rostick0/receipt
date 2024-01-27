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
        Schema::create('folder_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->references('id')->on('folders')->onDelete('cascade');
            $table->foreignId('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folder_receipts');
    }
};
