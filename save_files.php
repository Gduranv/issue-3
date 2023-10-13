<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $filename = $_POST['filename'];

    if ($content !== null && $filename !== null) {
        $carpeta_destino = 'files/'; // Ruta de destino

        // Agregar .txt al final del nombre de archivo si no tiene una extensión
        if (pathinfo($filename, PATHINFO_EXTENSION) !== 'txt') {
            $filename .= '.txt';
        }

        $ruta_completa = $carpeta_destino . $filename;

        $guardado = file_put_contents($ruta_completa, $content);

        if ($guardado !== false) {
            echo 'Archivo guardado exitosamente.';
        } else {
            echo 'Error al guardar el archivo.';
        }
    } else {
        echo 'Faltan datos para guardar el archivo.';
    }
}
?>