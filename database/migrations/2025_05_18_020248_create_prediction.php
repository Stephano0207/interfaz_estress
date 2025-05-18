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
        Schema::create('prediction', function (Blueprint $table) {
            $table->id();
            $table->float("Study_Hours_Per_Day");
            $table->float("Extracurricular_Hours_Per_Day");
            $table->float("Sleep_Hours_Per_Day");
            $table->float("Social_Hours_Per_Day");
            $table->float("Physical_Activity_Hours_Per_Day");
            $table->float("GPA");
            $table->string("Stress_Level");

            // Nuevos campos
            $table->string("nombres");
            $table->string("apellidos");
            $table->string("carrera");
            $table->integer("ciclo");
            $table->string("sexo", 20);
            $table->integer("edad");

            $table->timestamps(); // Reactivar timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediction');
    }
};
