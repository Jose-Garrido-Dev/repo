<?php

//pipe es una función que recibe un valor y una serie de funciones y las aplica en secuencia

function showNames(...$names){
    foreach($names as $name){
        echo $name."<br>";
    }
}


// showNames("Ana", "Luis", "Carlos");

function pipe(...$funcs){
    return function ($value) use ($funcs){
        foreach($funcs as $fn){
            $value = $fn($value);
        }
        return $value;
    };
}
$toUpper = fn($s) => strtoupper($s);
$replaceSpace = fn($s) => str_replace(" ","",$s);
$replaceNumbers = fn($s) => preg_replace('/\d+/u','',$s);// esta exp regular dice  con \d+ que reemplace cualquier dígito (0-9) y con + que puede ser uno o más dígitos consecutivos y con u que sea una cadena unicode

$myPipe = pipe($toUpper, $replaceSpace, $replaceNumbers);// aqui lo que hace pipe el resultado de $toupper se lo pasará a $replaceSpace y luego este ultimo a  $replaceNumbers
$result  = $myPipe("abdc143243 fdjksjs sshol33a 3dfjdf");
echo $result;