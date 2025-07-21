<?php
declare(strict_types=1); // Habilita el tipado estricto
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


function hi($name){
    echo "Hola $name";
}
hi("Jose Garrido\n"."<br>");
hi("luis fuentes\n"."<br>");
hi("benjamin Garrido\n"."<br>");

echo summ(10,20);

//le pasamos el tipado a lo que recibe y devuelve la funcion
function summ(int $a,int $b): int{
    $result=$a+$b;
    return $result;
}