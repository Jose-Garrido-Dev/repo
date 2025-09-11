<?php
//esta function array_udiff() es una funcion que permite comparar arrays de objetos
require "modelsArray/people.php";
require "modelsArray/functions.php";
// se agrega el namespace para crear objetos de la clase people
use ModelsArray\People;

$people1 = [
    new People("Juan", 45),
    new People("Maria", 30),
    new People("Pedro", 35),
    new People("Luis", 32)
];

$people2 = [
    new People("Ana", 28),
    new People("Luis", 32),
    new People("Carlos", 40),
    new People("Javier", 29)
];

// echo ("Juan" <=> "Maria")."<br>";
// echo ("Pedro" <=> "Luis")."<br>";
// echo ("Luis" <=> "Luis")."<br>"; devuelve 0



$differences = array_udiff($people1, $people2, 
fn($person1, $person2)
    => $person1->name <=> $person2->name
);

show($differences);// solamente retornará los elementos del primer array que no están en el segundo array