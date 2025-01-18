<?php
// path\app\Models\PostEtiqueta.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostEtiqueta extends Model
{
    use HasFactory;
    protected $table = 'tr_post_etiqueta';
    public $incrementing = false; // No hay clave primaria autoincremental
    public $timestamps = false;  // Si la tabla no tiene columnas created_at y updated_at
    protected $fillable = ['idpost', 'idetiqueta'];

}
