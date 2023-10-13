<!-- create_file.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = $_POST['filename'];
    $file_path = 'files/' . $filename . '.txt';

    if (!file_exists($file_path)) {
        file_put_contents($file_path, '');
        echo "Archivo '$filename' creado con éxito.";
    } else {
        echo "El archivo '$filename' ya existe.";
    }
}
?>
