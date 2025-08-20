<?php

class Car {
    private $model;
    private $brand;
    private $year;

    public function __construct(string $model, string $brand, int $year) {
        $this->model = $model;
        $this->brand = $brand;
        $this->year = $year;
    }

    public function __toString():string {
        return "Modelo: {$this->model}, Marca: {$this->brand}, Año: {$this->year}\n";
    }
}


$car = new Car("HRV", "Honda",2024);
$info = (string)$car;

echo gettype($info);