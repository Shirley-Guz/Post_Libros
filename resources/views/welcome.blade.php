<!-- resources/views/welcome.blade.php (o tu vista principal) -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Proyecto</title>
        @livewireStyles
    </head>
    <body>
        <!-- Incluir el componente Livewire -->
        @livewire('lista-post')

        @livewireScripts
    </body>
</html>
