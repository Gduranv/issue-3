<?php
if (isset($_POST['oldFolderName']) && isset($_POST['newFolderName'])) {
    $oldFolderName = 'files/' . $_POST['oldFolderName'];
    $newFolderName = 'files/' . $_POST['newFolderName'];

    if (is_dir($oldFolderName) && !is_dir($newFolderName)) {
        if (rename($oldFolderName, $newFolderName)) {
            echo 'Éxito: El nombre de la carpeta se ha cambiado correctamente.';
        } else {
            echo 'Error: No se pudo cambiar el nombre de la carpeta.';
        }
    } else {
        echo 'Error: La carpeta ya existe o la carpeta original no se encontró.';
    }
} else {
    echo 'Error: Parámetros incorrectos.';
}
?>

