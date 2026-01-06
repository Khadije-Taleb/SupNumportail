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
        // Drop users table if it exists from standard install
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');

        Schema::create('utilisateur', function (Blueprint $table) {
            $table->increments('id_utilisateur'); // Primary Key
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->enum('role', ['etudiant', 'admin']);
            $table->boolean('actif')->default(true);
            // No timestamps as per Model ($timestamps=false)
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index(); // Keep standard for now or adjust config
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateur');
        Schema::dropIfExists('sessions');
    }
};
