<?php
header('Content-Type: application/json'); // Configura el encabezado para respuesta JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['filename'])) {
    $filename = 'files/' . $_GET['filename'] . '.txt';
    $content = file_get_contents('php://input');
    
    if (file_put_contents($filename, $content) !== false) {
        $response = ['success' => true, 'message' => 'El archivo se ha guardado correctamente.'];
    } else {
        $response = ['success' => false, 'message' => 'Error al guardar el archivo.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Solicitud no válida.'];
}

echo json_encode($response); // Convierte el arreglo de respuesta a JSON
?>

