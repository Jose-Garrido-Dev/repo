<?php

$beer = [
    "name" => "Heineken",
    "type" => "Lager",
    "alcohol_content" => 5.0
];

$beer2 = [
    "name2" => "Heineken2",
    "type2" => "Lager2",
    "alcohol_content2" => 6.0
];

echo $beer['name'] . "<br>";

$beer["brewery"] = "Brewery D";

array_pop($beer);

// cuando no son array asociativos se incorproa con esta funcion nuevos elementos
//array_push($beer, "green_bottle");


echo count($beer) . "<br>";
print_r($beer);


if (in_array("Heineken", $beer)){
    echo "Heineken existe";
}else {
    echo "Heineken no existe";
}


$arraymezclado=array_merge($beer, $beer2);

echo "<pre>";
print_r($arraymezclado);
echo "</pre>";

