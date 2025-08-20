<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('partner_id');
            $table->uuid('instance_id');
            $table->uuid('contact_id')->nullable();
            $table->string('custom_code')->nullable()->index();

            $table->string('name');
            $table->string('number');
            $table->text('message')->nullable();

            $table->timestamp('scheduled_date')->nullable();
            $table->integer('status_id')->default(0);

            $table->text('error_message')->nullable();
            $table->string('delivery_status')->nullable();

            $table->timestamps();

            $table->unique(['partner_id', 'custom_code']);

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
            $table->foreign('instance_id')->references('id')->on('whatsapp_instances')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('whatsapp_contacts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
