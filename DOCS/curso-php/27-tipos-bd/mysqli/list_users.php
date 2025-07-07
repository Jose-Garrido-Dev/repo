<?php
// ---------- mysqli/list_users.php ----------
require 'funciones.php';
echo json_encode(listarUsuarios(), JSON_PRETTY_PRINT); // Muestra JSON
