<?php
$folders = glob('files/*', GLOB_ONLYDIR);

if ($folders) {
    echo "<h2>Lista de carpetas:</h2>";
    echo "<ul>";
    foreach ($folders as $folder) {
        $foldername = basename($folder);
        echo "<li>$foldername</li>";
    }
    echo "</ul>";
} else {
    echo "No hay carpetas en la carpeta principal.";
}
?>
