<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('carrera');
            $table->unsignedTinyInteger('ciclo');
            $table->unsignedTinyInteger('edad');
            $table->string('sexo', 32);
            $table->string('email')->nullable();

            $table->unsignedTinyInteger('item1');
            $table->unsignedTinyInteger('item2');
            $table->unsignedTinyInteger('item3');
            $table->unsignedTinyInteger('item4');
            $table->unsignedTinyInteger('item5');
            $table->unsignedTinyInteger('item6');
            $table->unsignedTinyInteger('item7');
            $table->unsignedTinyInteger('item8');

            $table->unsignedTinyInteger('total_score');      // 8..40
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->string('observaciones', 1000)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
