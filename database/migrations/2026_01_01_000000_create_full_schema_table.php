<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id();
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->enum('role', ['etudiant', 'admin']);
            $table->boolean('premiere_connexion')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('etudiant', function (Blueprint $table) {
            $table->string('matricule', 20)->primary();
            $table->unsignedBigInteger('utilisateur_id')->unique()->nullable();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email', 150);
            $table->enum('annee', ['L1', 'L2', 'L3', 'M1', 'M2']);
            $table->string('filiere', 100);

            $table->foreign('utilisateur_id')->references('id')->on('utilisateur')->onDelete('cascade');
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id')->unique()->nullable();
            $table->string('nom', 100)->nullable();
            $table->string('prenom', 100)->nullable();

            $table->foreign('utilisateur_id')->references('id')->on('utilisateur')->onDelete('cascade');
        });

        Schema::create('document', function (Blueprint $table) {
            $table->id();
            $table->string('nom_document', 100);
            $table->text('description')->nullable();
        });

        Schema::create('demande', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_etudiant', 20)->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->enum('statut', ['en_attente', 'en_cours_traitement', 'fin'])->default('en_attente');
            $table->text('remarque_admin')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('matricule_etudiant')->references('matricule')->on('etudiant')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('document');
            $table->foreign('admin_id')->references('id')->on('admin');
        });

        Schema::create('certificat_medical', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_etudiant', 20)->nullable();
            $table->string('photo_certificat');
            $table->enum('annee', ['L1', 'L2', 'L3', 'M1', 'M2']);
            // Allow common evaluation types by default so tests (sqlite) can insert them
            $table->enum('type_evaluation', ['devoir', 'examen', 'examen_pratique', 'tp', 'ecrit']);
            $table->date('date_absence');
            // Use standardized uppercase statuses by default
            $table->enum('statut', ['EN_ATTENTE', 'VALIDE', 'REFUSE'])->default('EN_ATTENTE');
            $table->text('remarque_admin')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('matricule_etudiant')->references('matricule')->on('etudiant')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admin');
        });

        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_etudiant', 20)->nullable();
            $table->text('message');
            $table->boolean('lu')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('matricule_etudiant')->references('matricule')->on('etudiant')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification');
        Schema::dropIfExists('certificat_medical');
        Schema::dropIfExists('demande');
        Schema::dropIfExists('document');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('etudiant');
        Schema::dropIfExists('utilisateur');
    }
};
