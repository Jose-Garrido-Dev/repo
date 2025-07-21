<?php

$beer = [
    "name" => "Heineken",
    "type" => "Lager",
    "alcohol_content" => 5.0
];

$beer["origin"] = "Netherlands";

foreach ($beer as $key => $value){
    echo "Aqui se imprime la key: ".$key.": Aqui su valor:".$value."<br>";
}