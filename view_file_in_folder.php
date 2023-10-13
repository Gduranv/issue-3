<?php
if (isset($_GET['foldername']) && isset($_GET['filename'])) {
    $foldername = $_GET['foldername'];
    $filename = $_GET['filename'];
    $filePath = 'files/' . $foldername . '/' . $filename;

    if (file_exists($filePath)) {
        // Lee el contenido del archivo y lo muestra
        $fileContent = file_get_contents($filePath);
        echo $fileContent;
    } else {
        // Manejo de error si el archivo no existe
        echo 'Error: El archivo no existe.';
    }
} else {
    // Manejo de error si no se proporciona el nombre de carpeta y/o archivo
    echo 'Error: Debe proporcionar el nombre de la carpeta y el archivo.';
}
?>
