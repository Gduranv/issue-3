<?php
if (isset($_GET['foldername'])) {
    $foldername = $_GET['foldername'];
    $folderPath = 'files/' . $foldername;
    
    $files = glob($folderPath . '/*.txt');

    $fileList = array();

    foreach ($files as $file) {
        // Obtén solo el nombre de archivo (sin la ruta completa)
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $fileList[] = $filename;
    }

    // Retorna la lista de archivos en formato JSON
    echo json_encode($fileList);
} else {
    // Manejo de error si no se proporciona un nombre de carpeta
    echo 'Error: Debe proporcionar un nombre de carpeta.';
}
?>




