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
            $table->float('cashTotalSum')->nullable();
            $table->float('creditSum')->nullable();
            $table->float('ecashTotalSum')->nullable();
            $table->string('code')->nullable();
            $table->string('fiscalDocumentFormatVer');
            $table->string('fiscalDocumentNumber');
            $table->string('fiscalDriveNumber');
            $table->string('fiscalSign');
            $table->string('kktRegId');
            $table->float('nds0');
            $table->float('ndsNo');
            $table->float('nds10');
            $table->float('nds20');
            // $table->integer('operationType');
            $table->integer('prepaidSum');
            $table->integer('provisionSum');
            $table->integer('requestNumber');
            $table->string('retailPlace');
            $table->string('retailPlaceAddress');
            $table->integer('shiftNumber');
            // $table->string('taxationType');
            $table->string('company');
            $table->integer('totalSum');
            $table->integer('user');
            $table->integer('userInn');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('OKVED');
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
