<?php

// ---------- pdo/list_users.php ----------

require 'funciones.php'; // Importa las funciones de usuario
$datos = listarUsuarios(); // Obtiene la lista de usuarios
echo json_encode($datos, JSON_PRETTY_PRINT); // Muestra en formato JSON bonito
