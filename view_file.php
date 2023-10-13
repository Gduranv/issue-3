<?php
if (isset($_GET['filename'])) {
    $filename = 'files/' . $_GET['filename'] . '.txt';

    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        echo $content;
    } else {
        echo "El archivo '$filename' no existe.";
    }
} else {
    echo "No se ha especificado un archivo para abrir.";
}
?>

