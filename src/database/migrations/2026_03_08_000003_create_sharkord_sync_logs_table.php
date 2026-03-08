<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sharkord_sync_logs', function (Blueprint $table): void {
            $table->id();
            $table->string('seat_user_id');
            $table->unsignedBigInteger('seat_character_id')->nullable();
            $table->string('sharkord_external_user_id')->nullable();
            $table->string('event_type');
            $table->string('request_id')->nullable();
            $table->string('status');
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->json('payload_excerpt_json')->nullable();
            $table->json('response_excerpt_json')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sharkord_sync_logs');
    }
};
