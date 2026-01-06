<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demande', function (Blueprint $table) {
            $table->increments('id_demande');
            $table->datetime('date_demande')->useCurrent();
            $table->enum('statut', ['en_attente', 'acceptee', 'rejetee'])->default('en_attente');
            $table->text('remarque_admin')->nullable();
            
            $table->string('matricule');
            $table->foreign('matricule')->references('matricule')->on('etudiant')->onDelete('cascade');
            
            $table->integer('id_document')->unsigned();
            $table->foreign('id_document')->references('id_document')->on('document')->onDelete('cascade');
            
            $table->integer('id_admin')->unsigned()->nullable();
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demande');
    }
};
