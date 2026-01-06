<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificat_medical', function (Blueprint $table) {
            $table->increments('id_certificat');
            
            $table->string('matricule');
            $table->foreign('matricule')->references('matricule')->on('etudiant')->onDelete('cascade');
            
            $table->string('niveau');
            $table->string('type_activite');
            $table->datetime('date_activite');
            $table->string('photo_certificat')->nullable();
            $table->enum('statut', ['en_attente', 'acceptee', 'rejetee'])->default('en_attente');
            $table->text('remarque_admin')->nullable();
            $table->datetime('date_upload')->useCurrent();
            
            $table->integer('id_admin')->unsigned()->nullable();
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificat_medical');
    }
};
