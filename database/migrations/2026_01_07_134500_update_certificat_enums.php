<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update type_evaluation to include all used values is essential
        // We use raw statement because modifying enums with Schema builder can be tricky without dbal
        // Only run this raw statement on MySQL (SQLite used by tests cannot run ALTER ... MODIFY)
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE certificat_medical MODIFY COLUMN type_evaluation ENUM('devoir', 'examen', 'examen_pratique', 'tp', 'ecrit') NOT NULL");
        }

        // Also ensure statut supports both cases or strictly match definition?
        // The table has ['en_attente', 'en_cours_traitement', 'fin']
        // We will stick to the table definition and fix the code, but just in case we can expand it if we wanted.
        // For now, only type_evaluation is critical blocking.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert is risky if data exists, but we can reset to 'ecrit' if we wanted (not recommended for data preservation)
        // DB::statement("ALTER TABLE certificat_medical MODIFY COLUMN type_evaluation ENUM('ecrit') NOT NULL");
    }
};
