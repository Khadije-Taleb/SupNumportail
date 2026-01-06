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
        Schema::table('certificat_medical', function (Blueprint $table) {
            $table->renameColumn('matricule', 'etudiant_matricule');
            $table->renameColumn('niveau', 'annee');
            $table->renameColumn('type_activite', 'type_evaluation');
            $table->renameColumn('date_activite', 'date_evaluation');
            $table->renameColumn('photo_certificat', 'fichier');
            $table->renameColumn('id_admin', 'admin_id');
        });

        // Use raw query for enum modification if necessary, or just change type to string
        Schema::table('certificat_medical', function (Blueprint $table) {
            $table->string('statut')->default('EN_ATTENTE')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificat_medical', function (Blueprint $table) {
            $table->renameColumn('etudiant_matricule', 'matricule');
            $table->renameColumn('annee', 'niveau');
            $table->renameColumn('type_evaluation', 'type_activite');
            $table->renameColumn('date_evaluation', 'date_activite');
            $table->renameColumn('fichier', 'photo_certificat');
            $table->renameColumn('admin_id', 'id_admin');
        });
        
        Schema::table('certificat_medical', function (Blueprint $table) {
             $table->enum('statut', ['en_attente', 'acceptee', 'rejetee'])->default('en_attente')->change();
        });
    }
};
