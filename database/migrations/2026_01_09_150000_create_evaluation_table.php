<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('evaluation')) {
            Schema::create('evaluation', function (Blueprint $table) {
                $table->id();
                $table->string('matiere', 100);
                $table->string('type_evaluation', 100);
                $table->timestamps();

                $table->unique(['matiere', 'type_evaluation']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation');
    }
};
