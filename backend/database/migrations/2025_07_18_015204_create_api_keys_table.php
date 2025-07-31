<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id')->nullable();
            $table->uuid('partner_id');

            $table->string('key', 128)->unique();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->json('scopes')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('partner_id')->references('id')->on('partners')->cascadeOnDelete();

            $table->index(['user_id', 'partner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
