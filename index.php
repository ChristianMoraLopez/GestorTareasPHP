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
        <input type="text" name="nombre_archivo" placeholder="Nombre del archivo JSON" required>
            <input type="text" name="descripcion" placeholder="Descripción de la tarea" required>
            <button type="submit" name="agregar">Agregar Tarea</button>

        </form>
        <ul>
        <?php
        // Verificar si se ha proporcionado el nombre del archivo
        if (isset($_POST['nombre_archivo'])) {
            $nombre_archivo = $_POST['nombre_archivo'];
            $archivo_tareas = $nombre_archivo . '.json';
            
            // Resto del código para manejar las tareas
            // Inserta aquí el código PHP proporcionado en la respuesta anterior
        ?>
        
        <ul>
            <?php
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
        
        <?php
        // Cierre de la estructura condicional PHP
        }
        ?>
        </ul>
    </div>
</body>
</html>