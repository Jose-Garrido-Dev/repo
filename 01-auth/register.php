<?php
require 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password= password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'] ?? 'user'; // op, por defecto user

    $sql = "INSERT INTO usuarios(nombre, email, password, rol) VALUES (?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre,$email,$password,$rol]);

    echo "Usuario Registrado";
}

?>

<form method="POST">
    nombre: <input name="nombre"><br>
    Email: <input name="email" type="email"><br>
    contraseña: <input name="password" type="password"><br>
    Rol: 
        <select name="rol" id="">
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select><br>
        <button>Registrar</button>
</form>