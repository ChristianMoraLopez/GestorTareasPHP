<?php
// Función para guardar las tareas en un archivo JSON
function guardar_tareas($archivo, $tareas) {
    file_put_contents($archivo, json_encode($tareas));
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
        
    </h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?nombre_archivo=<?php echo urlencode($nombre_archivo); ?>" method="post">
    <input type="text" name="descripcion" placeholder="Descripción de la tarea" required>
        <button type="submit" name="agregar">Agregar Tarea</button>
    </form>

    <ul>
        <?php
        if (isset($_POST['agregar'])) {
            // Código PHP para agregar una tarea
            $descripcion = $_POST['descripcion'];
            $tarea = [
                'descripcion' => $descripcion,
                'completada' => false
            ];
            $tareas[] = $tarea;
            guardar_tareas($archivo_tareas, $tareas);
        } elseif (isset($_POST['eliminar'])) {
            // Código PHP para eliminar una tarea
            $indice = $_POST['indice'];
            unset($tareas[$indice]);
            guardar_tareas($archivo_tareas, $tareas);
        } elseif (isset($_POST['completar'])) {
            // Código PHP para marcar una tarea como completada
            $indice = $_POST['completar'];
            $tareas[$indice]['completada'] = true;
            guardar_tareas($archivo_tareas, $tareas);
        }

        // Código PHP para mostrar la lista de tareas
        if (!empty($tareas)) {
            foreach ($tareas as $indice => $tarea) {
                echo '<li';
                if ($tarea['completada']) {
                    echo ' style="text-decoration: line-through; color: darkgray;"';
                }
                echo '>' . $tarea['descripcion'];

                // Botón de eliminar
                echo '<form method="post" style="display: inline;">
                        <input type="hidden" name="indice" value="' . $indice . '">
                        <button type="submit" name="eliminar">(X)</button>
                      </form>';

                // Botón de completar
                echo '<form method="post" style="display: inline;">
                        <input type="hidden" name="completar" value="' . $indice . '">
                        <button type="submit">Completar</button>
                      </form>';

                echo '</li>';
            }
        } else {
            echo '<li>No hay tareas pendientes.</li>';
        }
        ?>
    </ul>
</div>

</body>
</html>
