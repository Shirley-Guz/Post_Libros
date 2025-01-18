<?php
// path\app\Models\Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'te_posts';
    protected $primaryKey = 'idpost';
    protected $fillable = ['titulo', 'contenido'];


    public function categoria ()
    {
        return $this->belongsTo(Categorias::class, 'idcategoria', 'idcategoria');
    }

    // Relación muchos a muchos con etiquetas
    public function etiqueta()
    {
        return $this->belongsToMany(Etiquetas::class, 'tr_post_etiqueta', 'idpost', 'idetiqueta');

    }
}
