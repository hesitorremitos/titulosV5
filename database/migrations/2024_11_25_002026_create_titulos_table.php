<?php

use App\Models\Persona;
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
    Schema::create('registro_titulos', function (Blueprint $table) {
      $table->id();
      // Llave foranea id de usuario
      $table->foreignId('user_id')->constrained('users', 'id');
      $table->foreignIdFor(Persona::class, 'ci')->constrained('personas', 'ci');
      $table->morphs('documentable');
      $table->string('path', 512);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('registro_titulos');
  }
};
