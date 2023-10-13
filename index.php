<!DOCTYPE html>
<html>
<head>
    <title>Bloc de Notas Web</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 20px;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
        }
        .menu-container {
            display: flex;
        }
        .menu {
            margin-right: 10px; /* Ajusta el margen según tu preferencia */
        }
        .menu-button {
            background-color: #0077cc;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .menu-options {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            z-index: 1;
        }

        .menu-options a {
            display: block;
            text-decoration: none;
            padding: 5px;
        }

        .menu-button:hover + .menu-options, .menu-options:hover {
            display: block;
        }

        .menu-options form {
            display: none;
            padding: 10px;
        }

        textarea {
            width: 100%;
            height: 400px;
            padding: 10px;
            margin-top: 20px;
            font-family: 'Lucida Console', Monaco, monospace;
            border: 1px solid #ccc;
        }

        /* Estilo para la ventana modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 60%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .file-list {
            list-style-type: none;
            padding: 0;
        }

        .file-list li {
            margin: 5px 0;
        }

        .file-list a {
            text-decoration: none;
            color: #0077cc;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Bloc de Notas Web</h1>

    <!-- Botón "Archivo" y opciones -->
    <div class="menu-container">
        <!-- Botón "Archivo" y opciones -->
        <div class="menu">
            <button class="menu-button" id="menuButton">Archivo</button>
            <div class="menu-options" id="menuOptions">
                <a href="#" onclick="createFile()">Nuevo</a>
                <a href="#" onclick="showFileList()">Abrir</a>
                <a href="#" onclick="saveFile()">Guardar</a>
                <a href="#" id="guardar-como">Guardar como...</a>
            </div>
        </div>

        <div class="menu">
            <!-- Botón "Carpeta" y opciones -->
            <button class="menu-button" id="folderButton">Carpeta</button>
            <div class="menu-options" id="folderOptions">
                <a href="#" onclick="showFolderList()">Abrir Carpeta</a>
                <a href="#" onclick="showFolder('crear')">Crear Carpeta</a>
            </div>
        </div>
    </div>
    

    <textarea placeholder="Escribe aquí..." id="textArea"></textarea>

    <!-- Ventana modal para la lista de archivos -->
    <div id="fileModal" class="modal">
        <div class="modal-content">
            <h2>Selecciona un archivo</h2>
            <ul class="file-list">
                <!-- PHP para listar archivos -->
                <?php
                $files = glob('files/*.txt');
                if ($files) {
                    foreach ($files as $file) {
                        $filename = pathinfo($file, PATHINFO_FILENAME);
                        echo "<li><a onclick='selectFile(\"$filename\")'>$filename</a></li>";
                    }
                } else {
                    echo "<li>No hay archivos en la carpeta.</li>";
                }
                ?>
            </ul>
            <button onclick="closeFileModal()">Cerrar</button>
        </div>
    </div>

<!-- Ventana modal para abrir carpeta -->
<div id="openFolderModal" class="modal">
    <div class="modal-content">
        <h2>Selecciona una carpeta</h2>
        <ul class="folder-list">
            <!-- PHP para listar carpetas en la carpeta "files" -->
            <?php
            $folders = glob('files/*', GLOB_ONLYDIR);
            if ($folders) {
                foreach ($folders as $folder) {
                    $foldername = basename($folder);
                    echo "<li><a href='#' onclick='selectFolder(\"$foldername\")'>$foldername</a></li>";
                }
            } else {
                echo "<li>No hay carpetas en la carpeta 'files'.</li>";
            }
            ?>
        </ul>
        <button onclick="closeFolderModal()">Cerrar</button>
    </div>
</div>

    <!-- Ventana modal para crear una carpeta -->
    <div id="createFolderForm" class="modal">
    <div class="modal-content">
        <h2>Crear Carpeta</h2>
        <form method="post" action="create_folder.php" onsubmit="createFolder(); return false;">
            <input type="text" id="folderNameInput" placeholder="Nombre de la carpeta">
            <input type="submit" value="Crear Carpeta">
        </form>
        <button onclick="closeFolderForm('crear')">Cancelar</button>
    </div>
</div>

    <!-- JavaScript para manejar la ventana emergente de la lista de archivos -->
    <script>
        const menuButton = document.getElementById('menuButton');
        const menuOptions = document.getElementById('menuOptions');
        const fileModal = document.getElementById('fileModal');
        let currentFileName = null;

        const folderButton = document.getElementById('folderButton');
        const folderOptions = document.getElementById('folderOptions');
        const openFolderModal = document.getElementById('openFolderModal');
        const openFolderButton = document.getElementById('openFolderButton');
        let selectedFolder = null;
        
        

        // Función para mostrar opciones de carpeta
        folderButton.addEventListener('click', () => {
            folderOptions.style.display = folderOptions.style.display === 'block' ? 'none' : 'block';
        });

        function showOption(option) {
            document.getElementById(option + 'Option').style.display = 'block';
        }

        function createFile() {
            const filename = prompt("Ingrese el nombre del archivo:");
            if (filename !== null && filename.trim() !== "") {
                // Envía el nombre del archivo al servidor
                const form = document.createElement("form");
                form.method = "post";
                form.action = "create_file.php";
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "filename";
                input.value = filename;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function saveFile() {
            // Obtén el contenido del textarea
            const fileContent = document.getElementById('textArea').value;

            if (currentFileName) {
                // Realiza una solicitud POST para guardar el contenido en el archivo
                fetch(`save_file.php?filename=${currentFileName}`, {
                    method: 'POST',
                    body: fileContent,
                    headers: {
                        'Content-Type': 'text/plain',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('El archivo se ha guardado correctamente en el servidor.');
                    } else {
                        alert('Error al guardar el archivo en el servidor: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Error al guardar el archivo en el servidor.');
                });
            } else {
                alert('No se ha seleccionado un archivo para guardar.');
            }
        }

        function showFileList() {
            fileModal.style.display = 'block';
        }

        function selectFile(filename) {
            // Cargar el contenido del archivo seleccionado en el textarea
            const fileContent = document.getElementById('textArea');
            currentFileName = filename;

            // Realiza una solicitud al servidor para obtener el contenido del archivo
            fetch(`view_file.php?filename=${filename}`)
                .then(response => response.text())
                .then(data => {
                    fileContent.value = data;
                })
                .catch(error => {
                    console.error(error);
                    fileContent.value = `Error al cargar el archivo '${filename}'.`;
                });

            closeFileModal();
        }

        // Función para cerrar la ventana modal de archivos
        function closeFileModal() {
            fileModal.style.display = 'none';
        }

        function showFolder(option) {
        if (option === 'crear') {
            const folderForm = document.getElementById('createFolderForm');
            folderForm.style.display = 'block';
        }
    }

    function createFolder() {
        const folderNameInput = document.getElementById('folderNameInput');
        const folderName = folderNameInput.value.trim();
        if (folderName) {
            // Envía el nombre de la carpeta al servidor
            const form = new FormData();
            form.append('foldername', folderName);
            fetch('create_folder.php', {
                method: 'POST',
                body: form
            })
            .then(response => response.text())
            .then(message => {
                alert(message);
                if (message.includes('éxito')) {
                    closeFolderForm('crear');
                }
            })
            .catch(error => {
                alert('Error al crear la carpeta: ' + error);
            });
        } else {
            alert('Ingresa un nombre de carpeta válido.');
        }
    }

    function closeFolderForm(option) {
        if (option === 'crear') {
            const folderForm = document.getElementById('createFolderForm');
            folderForm.style.display = 'none';
        }
    }

    function showFolderList() {
    openFolderModal.style.display = 'block';
    }

    function closeFolderModal() {
    openFolderModal.style.display = 'none';
    }

    function selectFolder(foldername) {
    selectedFolder = foldername;
    // Aquí puedes realizar acciones adicionales cuando se selecciona una carpeta
    console.log(`Carpeta seleccionada: ${selectedFolder}`);
    }
    
    function showFolderList() {
        // Abre la ventana modal para mostrar la lista de carpetas
        openFolderModal.style.display = 'block';
    }

    function closeFolderModal() {
        // Cierra la ventana modal de carpetas
        openFolderModal.style.display = 'none';
    }

    function showFolder(option) {
    if (option === 'crear') {
        const folderForm = document.getElementById('createFolderForm');
        folderForm.style.display = 'block';
    } else if (option === 'editar') {
        const folderName = prompt("Nuevo nombre de la carpeta:");
        if (folderName !== null && folderName.trim() !== "") {
            // Envía el nuevo nombre de la carpeta al servidor
            const form = new FormData();
            form.append('oldFolderName', selectedFolder); // Nombre de la carpeta original
            form.append('newFolderName', folderName); // Nuevo nombre de la carpeta

            fetch('edit_folder.php', {
                method: 'POST',
                body: form
            })
            .then(response => response.text())
            .then(message => {
                alert(message);
                if (message.includes('éxito')) {
                    closeFolderForm('editar');
                }
            })
            .catch(error => {
                alert('Error al editar la carpeta: ' + error);
            });
        } else {
            alert('Ingresa un nombre de carpeta válido.');
        }
    }
}

    document.getElementById("guardar-como").addEventListener("click", function () {
    var contenido = document.getElementById("textArea").value; // Asegúrate de usar el elemento correcto para obtener el contenido

    // Abre un cuadro de diálogo para ingresar el nombre del archivo
    var nombreArchivo = prompt("Nombre del archivo a guardar:", currentFileName);

    if (nombreArchivo) {
        currentFileName = nombreArchivo; // Actualiza el nombre del archivo actual
        var formData = new FormData();
        formData.append("content", contenido);
        formData.append("filename", nombreArchivo);

        fetch("save_files.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((result) => {
                alert(result); // Muestra la respuesta del servidor
            })
            .catch((error) => {
                console.error("Error al guardar el archivo: " + error);
            });
    }
});



    </script>
</body>
</html>
