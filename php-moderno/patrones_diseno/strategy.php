<?php

// IStrategy
// es un patron de diseño que permite definir una familia de algoritmos, encapsular cada uno de ellos y hacerlos intercambiables. Este patron permite que el algoritmo varíe independientemente de los clientes que lo utilizan.

interface IStrategy{
    public function get(): array;
}

class ArrayStrategy implements IStrategy{
    private array $data = ["Titulo 1", "Titulo 2", "Titulo 3"];

    public function get(): array {
        return $this->data;
    }
}

class UrlStrategy implements IStrategy{

    private string $url;

    public function __construct(string $url){
        $this->url = $url;
    }

    //para hacer la invocación a una url usamos función file_get_contents
    
    public function get():array{
        $data = file_get_contents($this->url); //solicitud por get, una vez qe tenemos esa solicitud cargada 
        //al ser json puedo decodificar el array
        $arr = json_decode($data,true);// si no le digo que es true lo toma como un objeto no como array
        return array_map(fn ($item) => $item["title"], $arr);
    }
}

class InfoPrinter {
    private IStrategy $strategy;

    public function __construct(IStrategy $strategy){
        $this->strategy = $strategy;
    }

    public function print(){
        $content = $this->strategy->get();
        foreach($content as $item){
            echo $item . "<br>";
        }
    }
}

$arrayStrategy = new ArrayStrategy();
$urlStrategy = new UrlStrategy("https://jsonplaceholder.typicode.com/posts");
// $infoPrinter = new InfoPrinter($arrayStrategy);
$infoPrinter = new InfoPrinter($urlStrategy);
$infoPrinter->print();