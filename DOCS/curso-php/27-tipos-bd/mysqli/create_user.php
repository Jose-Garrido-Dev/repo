<?php
// ---------- mysqli/create_user.php ----------
require 'funciones.php';
$id = crearUsuario('ana', 'clave456');   // Inserta usuario
echo "Insertado con ID $id";            // Resultado
