<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('telefone_uuid')->nullable(); // Relacionamento com Telefone
            $table->text('resposta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('telefone_uuid')->references('uuid')->on('telefone')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('message');
    }
}
