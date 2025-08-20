<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('whatsapp_messages', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(false)->after('delivery_status');
            $table->enum('recurrence_type', ['daily', 'weekly', 'monthly', 'quarterly', 'yearly'])
                ->nullable()
                ->after('is_recurring');
            $table->integer('recurrence_interval')->nullable()->after('recurrence_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_messages', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'recurrence_type', 'recurrence_interval']);
        });
    }
};
