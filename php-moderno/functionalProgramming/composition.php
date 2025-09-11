<?php
//la composicion de funciones es una forma de combinar dos o mas funciones en una sola similar a pipe pero a diferencia de este se lee de derecha a izqierda
function composition($fn1, $fn2){
    return function($value) use ($fn1, $fn2) {
        return $fn1($fn2($value));
    };
}

$add10 = fn($n) => $n+10;
$mul20 = fn($n) => $n*20;


$comp = composition($add10, $mul20);// primero se ejecuta mul20 y luego add10
echo $comp(4);