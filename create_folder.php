<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foldername = $_POST['foldername'];
    $folder_path = 'files/' . $foldername;

    if (!file_exists($folder_path)) {
        if (mkdir($folder_path, 0777, true)) {
            echo "Carpeta '$foldername' creada con éxito.";
        } else {
            echo "Error al crear la carpeta '$foldername'.";
        }
    } else {
        echo "La carpeta '$foldername' ya existe.";
    }
}
?>

