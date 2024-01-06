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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->timestamp('dateTime')->nullable();
            $table->integer('cashTotalSum')->nullable();
            $table->integer('creditSum')->nullable();
            $table->integer('ecashTotalSum')->nullable();
            $table->string('code')->nullable();
            $table->string('fiscalDocumentFormatVer')->nullable();
            $table->string('fiscalDocumentNumber');
            $table->string('fiscalDriveNumber');
            $table->string('fiscalSign');
            $table->string('kktRegId');
            $table->integer('nds0')->nullable();
            $table->integer('ndsNo')->nullable();
            $table->integer('nds10')->nullable();
            $table->integer('nds20')->nullable();
            $table->integer('operationType')->unsigned();
            $table->integer('prepaidSum')->nullable();
            $table->integer('provisionSum')->nullable();
            $table->integer('requestNumber')->nullable();
            $table->string('retailPlace')->nullable();
            $table->string('retailPlaceAddress')->nullable();
            $table->integer('shiftNumber')->nullable();
            $table->integer('taxationType')->unsigned();
            $table->integer('totalSum');
            $table->string('user');
            $table->string('userInn');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('okved_id')->references('id')->on('okveds')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
