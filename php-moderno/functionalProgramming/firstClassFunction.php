<?php

// función de primera clase (una funcion de primera clase es una función que se puede guardar dentro de una variable)

$somefunction = function(float $a, float $b): float {
    return $a + $b;
};

echo $somefunction(2,3);