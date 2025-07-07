<?php

// ---------- pdo/create_user.php ----------

require 'funciones.php'; // Importa las funciones de usuario

$id = crearUsuario('pedro','clave123'); // insertamos usuario
echo "Usuario creado con ID: $id\n"; // Mensaje de éxito