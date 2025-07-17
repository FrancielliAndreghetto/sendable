<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_instances', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('partner_id')->index();
            $table->string('api_id')->nullable()->index();
            $table->string('custom_code')->nullable()->index();

            $table->string('name');
            $table->string('whatsapp_number')->nullable();

            $table->string('token')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamp('connected_at')->nullable();
            $table->timestamp('disconnected_at')->nullable();

            $table->timestamps();

            $table->unique(['partner_id', 'api_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_instances');
    }
};
