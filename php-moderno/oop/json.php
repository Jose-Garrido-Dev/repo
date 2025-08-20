<?php


$beer = new Beer("Corona", 4.5, "Modelo", false);
$json = json_encode($beer); // convierte el objeto a JSON
// 
$jsonBeer = '{"name":"Corona","brand":"Modelo","alcohol":4.5,"isStrong":false}';
$objBeer = json_decode($jsonBeer); // convierte el JSON a un objeto
print_r($objBeer->name);

$arr = [
    "name" => "josé",
    "age" => 30,
    "isAdmin" => true,
    "skills" => ["PHP", "JavaScript", "Python"]
];

$newJson = json_encode($arr); // convierte el array a JSON

$newArr= json_decode($newJson, true);// para tratarlo como array asociativo
print_r($newArr['name']);


class Beer {
    public string $name;
    public string $brand;
    public float $alcohol;
    public bool $isStrong;

    public function __construct(string $name, float $alcohol, string $brand, bool $isStrong) {
        $this->name = $name;
        $this->alcohol = $alcohol;
        $this->brand = $brand;
        $this->isStrong = $isStrong;
    }

    // public function getName(): string {
    //     return $this->name;
    // }

    // public function getAlcohol(): float {
    //     return $this->alcohol;
    // }

}