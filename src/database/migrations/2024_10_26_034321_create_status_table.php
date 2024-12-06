<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusTable extends Migration
{
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('webhook_uuid')->nullable(); // Relacionamento com Webhook
            $table->uuid('message_uuid')->nullable(); // Relacionamento com Message
            $table->string('status');
            $table->text('status_descricao')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('webhook_uuid')->references('uuid')->on('webhook')->onDelete('set null');
            $table->foreign('message_uuid')->references('uuid')->on('message')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('status');
    }
}
