<?php
// path\app\Models\Categorias.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $table = 'ti_categorias';
    protected $primaryKey = 'idcategoria';
    protected $fillable = ['descripcion'];

    public function post()
    {
        return $this->hasMany(Post::class, 'idcategoria', 'idcategoria');
    }
}
