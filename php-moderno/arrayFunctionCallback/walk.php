<?php
// la function array_walk es una funcion que permite aplicar una funcion de callback a cada elemento de un array
// a diferencia de array_map no modifica el array original , array_walk si lo modifica si se pasa por referencia
require "modelsArray/functions.php";

$numbers = [1, 2, 3, 4, 5];
// con el & antes del dolar el array se pasa por referencia por ende se modifica el array  original
// no esta preprarado para el paso por referencia array_map
array_walk($numbers, fn(&$num) => $num *= 2);



show($numbers);

// otra forma de usar array_walk es con una funcion anonima , esto es equivalente a un foreach
array_walk($numbers, function($num){
    echo $num."<br>";
});
