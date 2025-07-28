<?php

// Comprobar si se envió el formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    $attachment = $_FILES["attachment"];

    // Definir el directorio donde se guardarán los archivos subidos
    $uploadDir = 'uploads/';

    // Si el directorio no existe, crearlo con permisos adecuados
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Mover el archivo desde la ubicación temporal a nuestro directorio 'uploads'
    if (move_uploaded_file($attachment['tmp_name'], $uploadDir . basename($attachment['name']))) {
        echo "<h2>Form submitted successfully!</h2>";
        echo "<p>Name: $name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Message: $message</p>";
        echo "<p>Attachment: " . htmlspecialchars($attachment['name']) . "</p>";

        // Mostrar el archivo subido y un botón para eliminarlo
        echo '<form method="POST" action="delete_file.php" class="mt-3">';
        echo '<input type="hidden" name="file_to_delete" value="' . $attachment['name'] . '">';
        echo '<button type="submit" class="btn btn-danger">Delete Attachment</button>';
        echo '</form>';
    } else {
        echo "<p>Error uploading file.</p>";
    }

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Form</title>
    <!-- Link to Bootstrap 4 for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos adicionales para darle un toque más bonito */
        body {
            background-color: #f7f7f7;
        }
        .jumbotron {
            background-color: #007bff;
            color: white;
        }
        .container {
            margin-top: 20px;
        }
        .form-control, .form-control-file {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <!-- Sección Jumbotron de bienvenida -->
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Our Contact Page</h1>
        <p class="lead">We would love to hear from you!</p>
    </div>

    <!-- Contenedor principal para el formulario -->
    <div class="container">
        <h1>Contact Form</h1>
        <p>Please fill out the form below to get in touch.</p>
        <!-- Formulario de contacto -->
        <form action="" method="post" class="mt-4" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="attachment">Attachment (optional):</label>
                <input type="file" name="attachment" id="attachment" class="form-control-file">
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
