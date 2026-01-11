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
        // First, add the new values without duplicating 'en_attente' if collation is case-insensitive
        // We'll just add the missing 'VALIDE' and 'REFUSE' for now
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE certificat_medical MODIFY COLUMN statut ENUM('en_attente', 'VALIDE', 'REFUSE', 'en_cours_traitement', 'fin') DEFAULT 'en_attente'");
        }

        // Update any existing 'en_cours_traitement' or 'fin' to 'VALIDE'
        DB::table('certificat_medical')->whereIn('statut', ['en_cours_traitement', 'fin'])->update(['statut' => 'VALIDE']);

        // Now, we want it to be internally consistent with the uppercase names in the app (EN_ATTENTE)
        // If MySQL complains about duplication, we'll just keep 'en_attente' but the filter will work
        // because MySQL ENUM comparison is usually case-insensitive.
        // BUT to be clean, let's try to rename 'en_attente' to 'EN_ATTENTE' by just changing the enum list
        // and hoping it maps, or just use lowercase everywhere in the code.

        // Decision: Let's use 'EN_ATTENTE', 'VALIDE', 'REFUSE' as the final state.
        // We'll DO IT IN ONE GO but WITHOUT the lowercase counterparts to avoid the collision error.
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE certificat_medical MODIFY COLUMN statut ENUM('EN_ATTENTE', 'VALIDE', 'REFUSE') DEFAULT 'EN_ATTENTE'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE certificat_medical MODIFY COLUMN statut ENUM('en_attente', 'en_cours_traitement', 'fin') DEFAULT 'en_attente'");
        }
    }
};
