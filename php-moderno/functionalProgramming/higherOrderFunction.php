<?php

// función de orden superior (una función de orden superior es una función que puede recibir otras funciones como argumentos o devolverlas)

$somefunction = function(float $a, float $b): float {
    return $a + $b;
};

function mul(float $a, float $b): float{
    return $a * $b;
}

//echo $somefunction(2,3);

function show(callable $fn, float $a, float $b): void {
    echo $fn($a, $b);
}

show("mul", 3,6);


echo "<br>";
echo "<h2>Arrow functions</h2>";
echo "<br>";

// las arrow functions son funciones anónimas que se definen con la sintaxis de "flecha" (=>) y tienen un alcance léxico de las variables.


$suma = fn(float $a, float $b): float => $a + $b;

echo $suma(4,5);

echo "<br>";
echo "<h2>use</h2>";
echo "<br>";

//captura de variables externas con "use"

$const = 10;

$suma = function(float $a, float $b) use($const): float {
    return $a + $b + $const;
};


echo $suma(3,2);