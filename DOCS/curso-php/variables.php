<?php

$pais="Chile";
$poblacion=120030435;
$densidad=12.2;

echo "El pais es: $pais , la población es: $poblacion y la densidad es $densidad personas por km2";
echo var_dump($pais);
echo var_dump($poblacion);
echo var_dump($densidad);


//Constantes

define("PI", 3.1416);

$status = 1201;
//agrupa dos valores el primero que coincida es 
$msg = match($status){
    200,1201 => "OK",
    201,1201 => "CREATED",
    202 => "ACCEPTED",
    204 => "NO CONTENT",
    400 => "BAD REQUEST",
    401 => "UNAUTHORIZED",
    403 => "FORBIDDEN",
    404,1201 => "NOT FOUND",
    500 => "INTERNAL SERVER ERROR",
    default => "UNKNOWN STATUS"
};

var_dump($msg);



$lista = ['A', 'B', 'C'];

[$a,$b] = $lista;


echo "El valor de a es: $a y el valor de b es: $b";


$num1=10;
$num2="20";
$resultado=$num1 + $num2;

echo "el valor es $resultado"; // 30


ECHO "<BR/>";
echo $_SERVER['SERVER_NAME']; // Muestra el nombre del archivo actual
echo $_SERVER['SERVER_ADDR']; // Muestra el nombre del archivo actual



//°F = °C × (9/5) + 32

function celsiusAFarhenheit($c){
    return $c * (9/5)+32;
}

echo "son: ".celsiusAFarhenheit(1)." °F";



for ($i = 1; $i <= 10; $i++) {
    if ($i === 5) continue;
    echo $i . ' ';
    if ($i === 8) break;
}


$carrito = [['producto'=>'polera', 'precio'=>10000],
           ['producto'=>'zapatos', 'precio'=>20000]];
$total=0;

foreach ($carrito as $value){
    echo $value['producto'] . "<br/>";
    $total += (int)$value['precio'];
    echo $total . '<br/>';
}           

