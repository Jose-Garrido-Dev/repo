<?php
// ---------- mysqli/update_user.php ----------
require 'funciones.php';
$id = (int)($_GET['id'] ?? 0);                    // Lee id
if ($id) {
  actualizarUsuario($id, 'ana2', null, 'admin'); // Cambia username y rol
  echo "Actualizado usuario $id";
}
