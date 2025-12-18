<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Transaction Identification
            $table->string('order_id')->unique(); // Generate unique: PORT-{timestamp}-{user_id}
            $table->string('transaction_id')->nullable(); // Dari Midtrans
            
            // Midtrans Response Data
            $table->string('payment_type')->nullable(); // credit_card, bank_transfer, dll
            $table->string('payment_method')->nullable(); // bca_va, gopay, dll
            $table->string('va_number')->nullable(); // Virtual Account Number jika ada
            
            // Transaction Details
            $table->enum('subscription_plan', ['pro_monthly', 'pro_yearly'])->nullable();
            $table->decimal('amount', 15, 2); // Total yang harus dibayar
            $table->decimal('admin_fee', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2); // Final amount
            
            // Status Management
            $table->enum('status', [
                'pending',      // Menunggu pembayaran
                'processing',   // Sedang diproses
                'success',      // Berhasil (subscription activated)
                'failed',       // Gagal
                'expired',      // Kadaluarsa (tidak dibayar dalam waktu tertentu)
                'cancelled'     // Dibatalkan
            ])->default('pending');
            
            // Timestamps dari Midtrans
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable(); // Batas waktu pembayaran
            
            // Subscription Period
            $table->timestamp('subscription_start_date')->nullable();
            $table->timestamp('subscription_end_date')->nullable();
            
            // Midtrans Raw Response (untuk debugging)
            $table->json('midtrans_response')->nullable();
            
            // Notes
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('user_id');
            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};