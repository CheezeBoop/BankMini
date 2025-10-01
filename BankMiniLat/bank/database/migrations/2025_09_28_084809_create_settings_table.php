<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('minimal_setor')->default(10000);
            $table->bigInteger('maksimal_setor')->default(10000000);
            $table->bigInteger('minimal_tarik')->default(10000);
            $table->bigInteger('maksimal_tarik')->default(5000000);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
