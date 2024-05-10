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
        <h1>Gestor de Tareas</h1>
        <form action="
        <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- Iniciamos una etiqueta de php para poder hacer uso de las variables superglobales $_SERVER y $_POST.
        Se ejecutará en el servidor ante de que se envíe la página al cliente.
        htmlspecialchars es un función que convierte caracteres especiales en entidades HTML para evitar ataques XSS.
        $_SERVER es una variable superglobal que contiene información sobre encabezados, rutas y ubicaciones de scripts.
        Devuelve el nombre del archivo del script actual.


$_SERVER["PHP_SELF"] es una variable superglobal en PHP que almacena el nombre del archivo del script PHP que se está ejecutando actualmente.

Cuando se utiliza en el contexto de un formulario HTML, como en el atributo action, $_SERVER["PHP_SELF"] devuelve la ruta relativa al archivo PHP actual. 
Por ejemplo, si el archivo PHP actual se llama "formulario.php" y se encuentra en el directorio raíz del sitio web, $_SERVER["PHP_SELF"] devolverá "/formulario.php". 
Esto permite que el formulario envíe los datos al mismo script PHP que lo procesa.
        
        Y el método post se utiliza para enviar datos al servidor. -->
        <input type="text" name="descripcion" placeholder="Descripción de la tarea" required>
            <button type="submit" name="agregar">Agregar Tarea</button>
        </form>
        <ul>
        <?php
            $archivo_tareas = '/tareas.json';
            if (file_exists($archivo_tareas)) {
                $contenido = file_get_contents($archivo_tareas);
                $tareas = json_decode($contenido, true);
            } else {
                $tareas = [];
                file_put_contents($archivo_tareas, json_encode($tareas, JSON_PRETTY_PRINT));
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['agregar'])) {
                    $descripcion = $_POST['descripcion'];
                    $tareas[] = ['descripcion' => $descripcion, 'completada' => false];
                    file_put_contents($archivo_tareas, json_encode($tareas, JSON_PRETTY_PRINT));
                } elseif (isset($_POST['eliminar'])) {
                    $indice = $_POST['indice'];
                    unset($tareas[$indice]);
                    file_put_contents($archivo_tareas, json_encode($tareas, JSON_PRETTY_PRINT));
                } elseif (isset($_POST['completar'])) {
                    $indice = $_POST['completar'];
                    $tareas[$indice]['completada'] = true;
                    file_put_contents($archivo_tareas, json_encode($tareas, JSON_PRETTY_PRINT));
                }
            }

            if (!empty($tareas)) {
                foreach ($tareas as $indice => $tarea) {
                    echo '<li';
                    if ($tarea['completada']) {
                        echo ' style="text-decoration: line-through; color: darkgray;"';
                    }
                    echo '>' . $tarea['descripcion'] . '
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="indice" value="' . $indice . '">
                            <button type="submit" name="eliminar">(X)</button>
                        </form>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="completar" value="' . $indice . '">
                            <button type="submit">Completar</button>
                        </form>
                    </li>';
                }
            } else {
                echo '<li>No hay tareas pendientes.</li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>