<?php
// Función para guardar las tareas en un archivo JSON
function guardar_tareas($archivo, $tareas) {
    file_put_contents($archivo, json_encode($tareas));
}

function tarea_existe($tareas, $descripcion) {
    foreach ($tareas as $tarea) {
        if ($tarea['descripcion'] === $descripcion) {
            return true;
        }
    }
    return false;
}

// Función para cargar las tareas desde un archivo JSON
function cargar_tareas($archivo) {
    if (file_exists($archivo)) {
        $contenido = file_get_contents($archivo);
        return json_decode($contenido, true);
    } else {
        return [];
    }
}

// Obtener el nombre del archivo de tareas desde el parámetro GET
if (isset($_GET['nombre_archivo'])) {
    $nombre_archivo = $_GET['nombre_archivo'];
    $archivo_tareas = $nombre_archivo . '.json';
} else {
    // Si no se proporciona un nombre de archivo, redirigir a la página de inicio
    header("Location: index.php");
    exit();
}

// Cargar las tareas existentes
$tareas = cargar_tareas($archivo_tareas);

// Manejar el envío del formulario para agregar tareas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar'])) {
    $descripcion = $_POST['descripcion'];
    // Verificar si la tarea ya existe
    if (!tarea_existe($tareas, $descripcion)) {
        // Agregar la nueva tarea al array de tareas
        $tareas[] = array(
            'descripcion' => $descripcion,
            'completada' => false
        );
        // Guardar las tareas actualizadas
        guardar_tareas($archivo_tareas, $tareas);
        // Recargar la página para mostrar la nueva tarea
        header("Refresh:0");
    }
}

// Manejar el envío del formulario para completar una tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['completar'])) {
    $indice = $_POST['completar'];
    // Marcar la tarea como completada
    $tareas[$indice]['completada'] = !$tareas[$indice]['completada'];
    // Guardar las tareas actualizadas
    guardar_tareas($archivo_tareas, $tareas);
    // Recargar la página para aplicar los cambios
    header("Refresh:0");
}

// Manejar el envío del formulario para eliminar una tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $indice = $_POST['indice'];
    // Eliminar la tarea del array de tareas
    array_splice($tareas, $indice, 1);
    // Guardar las tareas actualizadas
    guardar_tareas($archivo_tareas, $tareas);
    // Recargar la página para aplicar los cambios
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Lista de tareas - <?php echo $nombre_archivo; ?></h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?nombre_archivo=<?php echo urlencode($nombre_archivo); ?>" method="post">
        <input type="text" name="descripcion" placeholder="Descripción de la tarea" required  autocomplete="off">
        <button type="submit" name="agregar">Agregar Tarea</button>
    </form>

    <ul>
        <?php
        if (!empty($tareas)) {
            foreach ($tareas as $indice => $tarea) {
                echo '
                <container class="TaskContainer">
                    <li';
                if ($tarea['completada']) {
                    echo ' style="text-decoration: line-through; color: darkgray;"';
                }
                echo '>' . $tarea['descripcion'];
    
                // Botón de completar
                echo '<form method="post" style="display: inline;">
                            <input type="hidden" name="completar" value="' . $indice . '">
                            <button type="submit" class="complete-button">Completar</button>
                          </form>';
    
                // Botón de eliminar
                echo '<form method="post" style="display: inline;">
                            <input type="hidden" name="eliminar" value="' . $indice . '">
                            <button type="submit" class="delete-button">(X)</button>
                          </form>';
    
                echo '</li>
                </container>';
            }
        } else {
            echo '<li>No hay tareas pendientes.</li>';
        }
        ?>
    </ul>
</div>

<footer>
    <p><a href="index.php">Volver al inicio</a></p>
</footer>
</body>
</html>
