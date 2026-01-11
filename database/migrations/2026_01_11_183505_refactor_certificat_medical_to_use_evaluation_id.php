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
            // Add evaluation_id column
            $table->unsignedBigInteger('evaluation_id')->nullable()->after('annee');
            
            // Add foreign key constraint
            $table->foreign('evaluation_id')
                  ->references('id')
                  ->on('evaluation')
                  ->onDelete('restrict');
            
            // Drop old columns (matiere and type_evaluation will be removed after data migration)
            // We'll keep them temporarily to migrate data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificat_medical', function (Blueprint $table) {
            $table->dropForeign(['evaluation_id']);
            $table->dropColumn('evaluation_id');
        });
    }
};
