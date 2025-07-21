<?php

declare(strict_types=1);// strict types declaration
$sale= new Sale("2023-10-01");
$onlineSale = new OnlineSale("2023-10-02","tarjeta");
// echo $onlineSale->createInvoice();
$concept = new Concept("cerveza", 10.2);
$sale->addConcept($concept);

// echo $onlineSale->showInfo();
echo $sale->getTotal();
echo $sale->getDate();
 $sale->setDate("ewrgethrtrj");
// $concept = new Concept("cerveza", 10.2);
// $sale->addConcept($concept);
// print_r($sale);

// $sale->total=100;
// $sale->date=date("Y-m-d");
//Sale::reset(); // Resetea el contador de ventas
// print_r($sale);
//$sale= new Sale(10,"2023-10-01");
// echo "Total de ventas: " . Sale::$count . "<br>";
// echo gettype($sale->total);


//private es un modificador de acceso que indica que la propiedad o método solo puede ser accedido desde dentro de la clase misma.
//public es un modificador de acceso que indica que la propiedad o método puede ser accedido desde cualquier parte del código.
//static es un modificador de acceso que indica que la propiedad o método pertenece a la clase en sí, no a una instancia específica de la clase.
//protected es un modificador de acceso que indica que la propiedad o método puede ser accedido desde la clase misma y desde las clases que heredan de ella, pero no desde fuera de estas clases.

//El concepto de clases y objetos es fundamental en la programación orientada a objetos (OOP). Una clase es una plantilla o modelo que define las propiedades y comportamientos de un objeto. Un objeto es una instancia de una clase, que contiene datos y métodos para manipular esos datos.

class Sale{
    protected float $total;
    private string $date;
    private array $concepts;
    public static $count;
//el modo union stirng |double permite que el tipo de dato sea string o double
    public function __construct(string $date){
        $this->total=0;
        $this->date=$date;
        $this->concepts = [];
        self::$count++;// este contador es estatico, no pertenece a la instancia
    }

    public function addConcept(Concept $concept) {
        $this->concepts[] = $concept;
        $this->total+= $concept->amount;
    }

    public function getTotal(): float {
        return $this->total;
    }

    public function getDate():string{
        return $this->date;
    }

    public function setDate(string $date){

        if(strlen($date) > 10){
            echo "La fecha es incorrecta";
        }
        $this->date = $date;
    }

    public function createInvoice(): string {
        return "Se ha creado la factura";
    }


    // public function __destruct(){
    //     echo "Se ha eliminado el objeto Sale con total: {$this->total} y fecha: {$this->date}<br>";
    // }

    public static function reset(){
        self::$count = 0; // Resetea el contador de ventas
    }


}


class OnlineSale extends Sale {

    public $paymentMethod;

    public function __construct(string|double $date,
    string $paymentMethod ){
        
        parent::__construct($date);
        $this->paymentMethod = $paymentMethod;
    }

    public function showInfo():string {
        return "Total: {$this->total}, Date: {$this->date}, Payment Method: {$this->paymentMethod}";
    }
}


class Concept {
    public string $description;
    public float $amount;

    public function __construct(string $description, float $amount) {
        $this->description = $description;
        $this->amount = $amount;
    }
}