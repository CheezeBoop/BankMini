<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->string('nis_nip')->nullable()->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L','P'])->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['AKTIF','NONAKTIF'])->default('AKTIF');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('nasabah');
    }
};
