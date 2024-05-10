<?php
if (isset($_GET['nombre_archivo'])) {
    $nombre_archivo = $_GET['nombre_archivo'];
    $archivo_tareas = $nombre_archivo . '.json';
    
    if (file_exists($archivo_tareas)) {
        // El archivo de la lista de tareas existe, redirigir o mostrar un mensaje de éxito
        header("Location: gestordetareas.php?nombre_archivo=$nombre_archivo");
        exit();
    } else {
        // El archivo de la lista de tareas no existe, crearlo y mostrar un mensaje
        $mensaje = "La lista de tareas \"$nombre_archivo\" no existe. Se creará una nueva lista de tareas con ese nombre.";
        // Aquí podrías añadir la lógica para crear el archivo de la lista de tareas si lo deseas
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tareas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Escribe el nombre de la lista de tareas</h1>
        
        <form action="gestordetareas.php" method="get">
            <input type="text" name="nombre_archivo" placeholder="Nombre de tu lista de tareas" required>
            <button type="submit">Editar Tareas</button>
        </form>

        <?php
        if (isset($mensaje)) {
            echo "<p>$mensaje</p>";
        }
        ?>
    </div>

</body>
</html>
