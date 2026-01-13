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
        // Update existing notifications with 'student' role to 'etudiant'
        DB::table('notification')
            ->where('role', 'student')
            ->update(['role' => 'etudiant']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to 'student' if needed
        DB::table('notification')
            ->where('role', 'etudiant')
            ->update(['role' => 'student']);
    }
};
