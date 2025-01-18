<?php
// path\database\migrations\2025_01_02_010315_create_post_etiqueta_table.php
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
        Schema::create('tr_post_etiqueta', function (Blueprint $table) {
            $table->unsignedBigInteger('idpost');
            $table->unsignedBigInteger('idetiqueta');
           
            $table->foreign('idpost')->references('idpost')->on('te_posts')
            ->onDelete('cascade') // Si se elimina la categoría, se establece category_id como NULL
            ->onUpdate('cascade'); // Si se actualiza la categoría, se actualiza category_id en posts automáticamente
          
            $table->foreign('idetiqueta')->references('idetiqueta')->on('ti_etiquetas')
            ->onDelete('cascade') // Si se elimina la categoría, se establece category_id como NULL
            ->onUpdate('cascade'); // Si se actualiza la categoría, se actualiza category_id en posts automáticamente
              // Clave primaria compuesta
            $table->primary(['idpost', 'idetiqueta']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_post_etiqueta');
    }
};
