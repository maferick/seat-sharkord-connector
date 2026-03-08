<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sharkord_role_mappings', function (Blueprint $table): void {
            $table->id();
            $table->string('source_type');
            $table->string('source_key');
            $table->string('source_label');
            $table->string('sharkord_role_key');
            $table->string('sync_mode')->default('authoritative');
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sharkord_role_mappings');
    }
};
