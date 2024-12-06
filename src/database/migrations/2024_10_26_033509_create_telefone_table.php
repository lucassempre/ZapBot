<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefoneTable extends Migration
{
    public function up()
    {
        Schema::create('telefone', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('numero')->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telefone');
    }
}
