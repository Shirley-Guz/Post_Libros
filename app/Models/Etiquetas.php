<?php
// path\app\Models\Etiquetas.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiquetas extends Model
{
    use HasFactory;
    protected $table = 'ti_etiquetas';
    protected $primaryKey = 'idetiqueta';
    protected $fillable = ['descripcion'];

    // Relación muchos a muchos con posts

    public function post()
{
    return $this->belongsToMany(Post::class, 'tr_post_etiqueta', 'idetiqueta', 'idpost');
}

}
