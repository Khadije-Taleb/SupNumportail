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
            $table->unsignedBigInteger('id_utilisateur')->nullable()->after('id');
            $table->foreign('id_utilisateur')->references('id')->on('utilisateur')->onDelete('cascade');
        });

        // Migrate existing data
        $notifications = DB::table('notification')->get();
        foreach ($notifications as $notification) {
            $etudiant = DB::table('etudiant')->where('matricule', $notification->matricule_etudiant)->first();
            if ($etudiant) {
                DB::table('notification')
                    ->where('id', $notification->id)
                    ->update(['id_utilisateur' => $etudiant->utilisateur_id]);
            }
        }

        Schema::table('notification', function (Blueprint $table) {
            $table->string('matricule_etudiant')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropForeign(['id_utilisateur']);
            $table->dropColumn('id_utilisateur');
            $table->string('matricule_etudiant')->nullable(false)->change();
        });
    }
};
