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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembayaran')->unique(); // KKNM-PAY-YYYYMMDD-XXX
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('total_pembayaran');

            // Data minimal Midtrans
            $table->string('midtrans_snap_token')->nullable();
            $table->string('midtrans_payment_type')->nullable(); // bank_transfer, credit_card, dll
            $table->string('midtrans_bank')->nullable(); // BCA, BNI, dll (untuk bank_transfer)

            $table->enum('status', ['pending', 'sukses'])->default('pending');
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
