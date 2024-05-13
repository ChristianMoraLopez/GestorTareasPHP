<?php if (!file_exists($archivo_tareas)) {
    // El archivo de la lista de tareas no existe, crearlo y mostrar un mensaje
    $mensaje = "La lista de tareas \"$nombre_archivo\" no existe. Se creará una nueva lista de tareas con ese nombre.";
    
    // Aquí añadimos la lógica para crear el archivo de la lista de tareas si lo deseas
    $nueva_lista = []; // Creamos una nueva lista de tareas vacía
    $json_nueva_lista = json_encode($nueva_lista); // Convertimos la lista a formato JSON
    
    // Intentamos crear el archivo de la lista de tareas
    if (file_put_contents($archivo_tareas, $json_nueva_lista) !== false) {
        $mensaje .= " Se ha creado correctamente la lista de tareas.";
    } else {
        $mensaje .= " Ha ocurrido un error al intentar crear la lista de tareas.";
    }
}
?>
