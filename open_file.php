<?php
$files = glob('files/*.txt');

if ($files) {
    echo "<h2>Lista de archivos:</h2>";
    echo "<ul>";
    foreach ($files as $file) {
        $filename = pathinfo($file, PATHINFO_FILENAME);
        echo "<li>$filename</li>";
    }
    echo "</ul>";
} else {
    echo "No hay archivos en la carpeta.";
}
?>


