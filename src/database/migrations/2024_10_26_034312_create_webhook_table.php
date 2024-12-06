<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookTable extends Migration
{
    public function up()
    {
        Schema::create('webhook', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('message_uuid')->nullable();
            $table->uuid('telefone_uuid')->nullable();
            $table->text('payload')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('message_uuid')->references('uuid')->on('message')->onDelete('set null');
            $table->foreign('telefone_uuid')->references('uuid')->on('telefone')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook');
    }
}
