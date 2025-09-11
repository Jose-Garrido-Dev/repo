<?php

//la función array_filter permite filtrar un array
require "modelsArray/people.php";
require "modelsArray/functions.php";

use ModelsArray\People;


$people = [
    new People("Juan", 25),
    new People("Maria", 30),
    new People("Pedro", 35)
];

$greater25Years = array_filter($people, fn ($person))