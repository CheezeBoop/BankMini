<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rekening', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabah')->onDelete('cascade');
            $table->string('no_rekening')->unique();
            $table->date('tanggal_buka')->nullable();
            $table->enum('status', ['AKTIF','TUTUP'])->default('AKTIF');
            $table->bigInteger('saldo')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rekening');
    }
};
