<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sharkord_connector_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('sharkord_base_url');
            $table->string('sharkord_api_base_path')->default('/api/v1/ext');
            $table->string('signing_mode')->default('hmac');
            $table->text('signing_secret_encrypted_or_protected');
            $table->text('diagnostics_bearer_token_encrypted_or_protected')->nullable();
            $table->unsignedInteger('request_timeout_seconds')->default(10);
            $table->string('default_role_sync_mode')->default('authoritative');
            $table->string('main_character_strategy')->default('seat-primary-or-first');
            $table->json('allowed_alliance_ids_json')->nullable();
            $table->json('allowed_corp_ids_json')->nullable();
            $table->json('allowed_guest_groups_json')->nullable();
            $table->json('deny_groups_json')->nullable();
            $table->boolean('auto_push_disable_restore')->default(true);
            $table->boolean('dry_run_mode')->default(false);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sharkord_connector_settings');
    }
};
