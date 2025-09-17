<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekening_id')->constrained('rekening')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('jenis', ['SETOR','TARIK']);
            $table->bigInteger('nominal');
            $table->text('keterangan')->nullable();
            $table->bigInteger('saldo_setelah')->nullable();
            $table->enum('status', ['PENDING','CONFIRMED','REJECTED'])->default('PENDING');
            $table->boolean('admin_approved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaksi');
    }
};
