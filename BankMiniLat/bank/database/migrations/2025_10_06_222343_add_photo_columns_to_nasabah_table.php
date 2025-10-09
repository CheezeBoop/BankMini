<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('nasabah', function (Blueprint $table) {
            if (!Schema::hasColumn('nasabah','photo_path')) {
                $table->string('photo_path')->nullable()->after('email');
            }
            if (!Schema::hasColumn('nasabah','photo_thumb_path')) {
                $table->string('photo_thumb_path')->nullable()->after('photo_path');
            }
        });
    }
    public function down(): void {
        Schema::table('nasabah', function (Blueprint $table) {
            if (Schema::hasColumn('nasabah','photo_thumb_path')) $table->dropColumn('photo_thumb_path');
            if (Schema::hasColumn('nasabah','photo_path')) $table->dropColumn('photo_path');
        });
    }
};
