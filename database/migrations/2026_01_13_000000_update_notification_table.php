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
        Schema::table('notification', function (Blueprint $table) {
            $table->string('role')->default('student')->after('id_utilisateur');
            $table->string('title')->nullable()->after('role');
            $table->string('type')->nullable()->after('title');
            $table->renameColumn('lu', 'is_read');
            // Ensure timestamps if not present or consistent
            if (!Schema::hasColumn('notification', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->renameColumn('is_read', 'lu');
            $table->dropColumn(['role', 'title', 'type']);
        });
    }
};
