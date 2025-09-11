<?php
// closure  es una función anónima que puede acceder a variables fuera de su ámbito
function add(float $number){
    return function ($number2) use($number){
        return $number + $number2;
    };
}

function hi(){
    $count=0;
    return function() use(&$count){ // el ampersand es para pasar la variable por referencia y se pueda modifcar
        $count++;
        return " Hola $count";
    };
}

$s1=add(10);
echo $s1(20)."<br>";

echo $s1(10)."<br>";

$h1= hi();
echo $h1()."<br>";
echo $h1()."<br>";
echo $h1()."<br>";