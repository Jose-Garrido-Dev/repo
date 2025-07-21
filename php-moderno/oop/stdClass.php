<?php

$beer = new stdClass();
$beer->name= "Corona";
$beer->alcohol = 4.5;

echo $beer->name;

$arr = (array) $beer;

echo gettype($arr);

echo $arr['name'] . "\n";

$arrLocation = [
    "address" => "Calle Falsa 123",
    "country" => "Mexico",
];

$objLocation = (object) $arrLocation;

echo $objLocation->address . "\n";
echo $objLocation->country . "\n";