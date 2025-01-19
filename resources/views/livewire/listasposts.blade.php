<?php

use function Livewire\Volt\{state}; // Importa la función 'state' de Livewire/Volt, aunque no se está utilizando en el código actual


use Livewire\Volt\Component; // Importa la clase base 'Component' de Livewire/Volt

use App\Models\Post; //Modelo de Post
use App\Models\Categorias; //Modelo de Categorias
use App\Models\Etiquetas; //Modelo de Etiquetas
use Illuminate\Validation\Rule;  // Importa la clase 'Rule' que se usa para reglas de validación

// Define una clase anónima que extiende 'Component', convirtiéndola en un componente Livewire

new class extends Component {

    // Variables públicas que se utilizan para almacenar la lista de posts, categorías, etiquetas y los datos del formulario.
    public $posts, $ti_categorias, $ti_etiquetas;
    public $titulo, $contenido, $idcategoria, $selected_etiquetas = [];
    public $editing = false, $idpost;

    /**
     * El método mount se ejecuta cuando se instancia el componente.
     * Se cargan todas las categorías y etiquetas de la base de datos,
     * y luego se cargan los posts existentes.
     */
    public function mount()
    {
        // Cargar todas las categorías y etiquetas desde la base de datos
        $this->ti_categorias = Categorias::all();
        $this->ti_etiquetas = Etiquetas::all();
        // Cargar los posts existentes
        $this->posts = Post::paginate(5); // Esto limita los resultados a 5 por página
        $this->loadPosts();
    }

    /**
     * Método para cargar los posts de la base de datos junto con sus categorías y etiquetas asociadas.
     */
    public function loadPosts()
    {
        // Obtener todos los posts y sus relaciones con categoría y etiquetas.
        $this->posts = Post::with('categoria', 'etiqueta')->get();
        // 
        //dd($this->posts->toArray());
    }

    /**
     * Método para guardar un nuevo post o actualizar uno existente.
     */
    public function save()
    {
        // Validar los datos del formulario

        // Validación de datos
        $this->validate([
            'titulo' => [
                'required',
                'min:5',
                Rule::unique('te_posts', 'titulo')->ignore($this->idpost, 'idpost') // Usar Rule::unique() correctamente
            ],
            'contenido' => 'required|min:3',
            'idcategoria' => 'required|exists:ti_categorias,idcategoria',
            'selected_etiquetas' => 'array|min:1',
        ], [
            'titulo.required' => 'El título es obligatorio y no puede estar vacío.',
            'titulo.min' => 'El título debe tener al menos 5 caracteres.',
            'titulo.unique' => 'Ya existe un post con ese título.',

            'contenido.required' => 'El contenido es obligatorio.',
            'contenido.min' => 'El contenido debe tener al menos 3 caracteres.',

            'idcategoria.required' => 'Seleccionar una categoría es obligatorio.',
            'idcategoria.exists' => 'La categoría seleccionada no existe en nuestros registros.',

            'selected_etiquetas.array' => 'Las etiquetas deben ser un arreglo.',
            'selected_etiquetas.min' => 'Debe seleccionar al menos una etiqueta.',
        ]);
        // Guardar o actualizar el post// Tu código para guardar el post}                                                                                                
        // Si estamos editando, buscamos el post por su ID, de lo contrario creamos uno nuevo.
        $post = $this->editing ? Post::find($this->idpost) : new Post();
        $post->titulo = $this->titulo; // Asignar el título
        $post->contenido = $this->contenido; // Asignar el contenido
        $post->idcategoria = $this->idcategoria; // Asignar la categoría seleccionada
        $post->save(); // Guardar el post

        // Sincronizar las etiquetas seleccionadas con el p
        $post->etiqueta()->sync($this->selected_etiquetas);

        // Resetear el formulario y cargar los posts nuevamente
        $this->loadPosts();
    }

    /**
     * Método para cargar los datos de un post en el formulario para editar.
     */
    public function edit($id)
    {
        // Limpiar los campos antes de cargar los datos
        $this->limpiarInput();
        // Buscar el post y sus etiquetas asociadas por ID
        $post = Post::with('etiqueta')->find($id);

        // Asignar los valores a las variables
        $this->titulo = $post->titulo;
        $this->contenido = $post->contenido;
        $this->idcategoria = $post->idcategoria;
        $this->selected_etiquetas = $post->etiqueta->pluck('idetiqueta')->toArray();
        $this->idpost = $post->idpost;
        $this->editing = true;
    }
    /**
     * Método para eliminar un post.
     */
    public function delete($id)
    {
        // Eliminar el post de la base de datos
        Post::find($id)->delete();
        // Cargar los posts nuevamente después de eliminar uno
        $this->loadPosts();
    }

    /**
     * Método para resetear los campos del formulario a sus valores iniciales.
     */
    public function limpiarInput()
    {
        $this->reset(['titulo', 'contenido', 'idcategoria', 'selected_etiquetas', 'editing', 'idpost']);
    }
}
?>
<!-- resources/views/livewire/lista-post.blade.php -->
<div class="container mt-5">
    <div class="row">
        <!-- Formulario para crear o editar un post -->
        <div class="col-md-4 bg-white shadow-sm rounded p-4">
            <h1 class="mb-4">Gestión de Posts Sobre Libros</h1>
            <form wire:submit.prevent="save" wire:key="form-post-{{ $idpost ?? 'new' }}" class="mb-4">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" wire:model="titulo" class="form-control" placeholder="Título">
                    @error('titulo') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea wire:model="contenido" class="form-control" style="height: 165px;" placeholder="Contenido"></textarea>
                    @error('contenido') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="idcategoria" class="form-label">Categoría</label>
                    <select wire:model="idcategoria" class="form-select">
                        <option value="">Seleccionar Categoría</option>
                        @foreach ($ti_categorias as $categoria)
                        <option value="{{ $categoria->idcategoria }}">{{ $categoria->descripcion }}</option>
                        @endforeach
                    </select>
                    @error('idcategoria') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Etiquetas</label>
                    <div class="row">
                        @foreach($ti_etiquetas as $etiqueta)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" wire:model="selected_etiquetas" value="{{ $etiqueta->idetiqueta }}">
                                <label class="form-check-label">{{ $etiqueta->descripcion }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('selected_etiquetas')
                    <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ $editing ? 'Actualizar' : 'Guardar' }}</button>
                    <button type="button" wire:click="limpiarInput" class="btn btn-secondary ms-2">Cancelar</button>
                </div>
            </form>
        </div>

        <!-- Tabla de posts -->
        <div class="col-md-8 bg-white shadow-sm rounded p-4">
            <h1 class="mb-4">Listado de Posts de Libros</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Etiquetas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr wire:key="post-{{ $post->idpost }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $post->titulo }}</td>
                        <td>{{ $post->categoria->descripcion }}</td>
                        <td>
                            @foreach($post->etiqueta as $etiquetas)
                            <span class="badge badge-info text-black">{{ $etiquetas->descripcion }}</span>
                            @endforeach
                        </td>
                        <td>
                            <button wire:click="edit({{ $post->idpost }})" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                            <button wire:click="delete({{ $post->idpost }})" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>