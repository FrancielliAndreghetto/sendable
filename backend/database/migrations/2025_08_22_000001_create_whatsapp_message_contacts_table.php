<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_message_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('partner_id');
            $table->uuid('message_id');
            $table->uuid('contact_id');
            $table->integer('status_id')->default(0);
            $table->string('delivery_status')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('message_id')->references('id')->on('whatsapp_messages')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('whatsapp_contacts')->onDelete('cascade');

            $table->index('partner_id');
            $table->index('message_id');
            $table->index('contact_id');
            $table->index('status_id');
            $table->index('delivery_status');
            $table->index(['partner_id', 'message_id']);
            $table->index(['partner_id', 'contact_id']);

            $table->unique(['message_id', 'contact_id'], 'unique_message_contact');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_message_contacts');
    }
};
