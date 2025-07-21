<?php

$beer = new Beer(10.2, "cerveza");
echo $beer->getName();
showInfo($beer);
function showInfo(Product $product){
    echo "$".$product->calculatePrice();
}

abstract class Product {
    protected float $price;
    protected string $name;

    abstract public function calculatePrice(): float;

    public function getName():string{
        return $this->name;
    }
}


class Beer extends Product {

    const TAX = 1.1;
    public function __construct($price, $name) {
        $this->price = $price;
        $this->name = $name;
    }

    public function calculatePrice(): float {
        return $this->price * self::TAX;
    }
}