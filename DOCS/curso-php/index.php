<?php
//VARIABLES
$num1=10;
$num2=12;
$texto="Hola mundo2";
$booleano = true;
$decimal = 10.5;
$nullValue = null;
$frutas = array("manzana", "banana", "naranja");
$persona = array(
    "nombre" => "Juan",
    "edad" => 30,
    "ciudad" => "Madrid"
);  


foreach ($persona as $clave){
    echo $clave["persona"];
}

echo $texto."<br>".$texto;
// Constantes
define('nombreConstante', 'Valor de la constante');
echo "<hr>";
foreach ($frutas as $fruta){
    echo $fruta."<br>";
}

$calculo = $num1> $num2 ? "El primero $num1 es mayor" : "El segundo numero $num2 es mayor o igual";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?=$texto?></h1>
    <h2><?=$calculo?></h2>
        <h2><?=$decimal?></h2>
            <h2><?=gettype($calculo)?></h2>
    <h2><?=nombreConstante?></h2>
        <h2><?=PHP_VERSION?></h2>

</body>
</html>
