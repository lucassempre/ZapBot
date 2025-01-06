<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('thread', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('webhook_uuid')->nullable();
            $table->uuid('telefone_uuid')->nullable();
            $table->string('thread_id');
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('webhook_uuid')->references('uuid')->on('webhook')->onDelete('set null');
            $table->foreign('telefone_uuid')->references('uuid')->on('telefone')->onDelete('set null');

        });
    }

    public function down()
    {
        Schema::dropIfExists('thread');
    }
};
