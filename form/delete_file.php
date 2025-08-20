<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fileToDelete = $_POST["file_to_delete"];
    $uploadDir = 'uploads/';

    // Eliminar el archivo
    $filePath = $uploadDir . basename($fileToDelete);
    if (file_exists($filePath)) {
        unlink($filePath);
        echo "<h2>File deleted successfully!</h2>";
         header('Location:index.php');
    } else {
        echo "<h2>File not found.</h2>";
    }
}
?>
