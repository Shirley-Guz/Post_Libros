<?php
// path\database\migrations\2025_01_02_004428_create_posts_table.php
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
        Schema::create('te_posts', function (Blueprint $table) {
            $table->bigIncrements('idpost');
            $table->string('titulo');
            $table->text('contenido');
            $table->unsignedBigInteger('idcategoria');
            $table->foreign('idcategoria')->references('idcategoria')->on('ti_categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('te_posts');
    }
};
