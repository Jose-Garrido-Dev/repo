<?php
session_start();
require 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM  usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    var_dump($usuario);

    if($usuario && password_verify($password,$usuario['password'])){
        //Guardamos usuario en session
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'rol' => $usuario['rol'],
        ];
        header('Location:dashboard.php');
        exit;
    }else {
        echo "Credenciales incorrectas";
    }

}



?>

<form method="POST">
    Email: <input name="email" type="email"><br/>
    Contraseña: <input type="password" name="password" ><br>
    <button>Iniciar Sesión</button>
</form>

