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
            $table->string('_id');
            $table->timestamp('dateTime')->nullable();
            $table->integer('cashTotalSum')->nullable();
            $table->integer('creditSum')->nullable();
            $table->integer('ecashTotalSum')->nullable();
            $table->bigInteger('code')->nullable();
            $table->bigInteger('fiscalDocumentFormatVer')->nullable();
            $table->bigInteger('fiscalDocumentNumber');
            $table->string('fiscalDriveNumber');
            $table->bigInteger('fiscalSign');
            $table->string('kktRegId');
            $table->integer('nds0')->nullable();
            $table->integer('ndsNo')->nullable();
            $table->integer('nds10')->nullable();
            $table->integer('nds18')->nullable();
            $table->integer('operationType')->unsigned();
            $table->integer('prepaidSum')->nullable();
            $table->integer('provisionSum')->nullable();
            $table->integer('requestNumber')->nullable();
            $table->string('retailPlace')->nullable();
            $table->string('retailPlaceAddress')->nullable();
            $table->integer('shiftNumber')->nullable();
            $table->string('operator')->nullable();
            $table->integer('taxationType')->unsigned();
            $table->integer('totalSum')->default(0);
            $table->string('user')->nullable();
            $table->string('userInn');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('okved_id')->nullable();
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
