<?php

// el patron de diseño factory es un patrón creacional que proporciona una interfaz para crear objetos en una superclase, pero permite que las subclases alteren el tipo de objetos que se crearán. Este patrón es útil cuando el proceso de creación de objetos es complejo o cuando el sistema debe ser independiente de cómo se crean, componen y representan los objetos.

interface Product {
    public function operation(): string;
}

class ConcreteProductA implements Product {
    public function operation(): string {
        return "Resultado de la operación del Producto A";
    }
}

class ConcreteProductB implements Product {
    public function operation(): string {
        return "Resultado de la operación del Producto B";
    }
}

abstract class Creator {
    abstract public function factoryMethod(): Product;

    public function someOperation(): string {
        $product = $this->factoryMethod();
        return "Creator: El mismo resultado de la operación de \n" . $product->operation();
    }
}

class ConcreteCreatorA extends Creator {
    public function factoryMethod(): Product {
        return new ConcreteProductA();
    }
}

class ConcreteCreatorB extends Creator {
    public function factoryMethod(): Product {
        return new ConcreteProductB();
    }
}

// Cliente
function clientCode(Creator $creator) {
    echo $creator->someOperation();
}

clientCode(new ConcreteCreatorA());
echo "<br>";
clientCode(new ConcreteCreatorB());

interface Beer {
    public function getDescription(): string;
}

class Lager implements Beer {
    public function getDescription(): string {
        return "Cerveza tipo Lager";
    }
}

class Ale implements Beer {
    public function getDescription(): string {
        return "Cerveza tipo Ale";
    }
}   

class Stout implements Beer {
    public function getDescription(): string {
        return "Cerveza tipo Stout";
    }
}

class BeerFactory {
    public static function createBeer(string $type): Beer {
        switch (strtolower($type)) {
            case 'lager':
                return new Lager();
            case 'ale':
                return new Ale();
            case 'stout':
                return new Stout();
            default:
                throw new Exception("Tipo de cerveza desconocido.");
        }
    }
}  

// Cliente
try {
    $beerType = 'Lager';
    $beer = BeerFactory::createBeer($beerType);
    echo "<br>";
    echo "Cerveza creada: " . $beer->getDescription() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
