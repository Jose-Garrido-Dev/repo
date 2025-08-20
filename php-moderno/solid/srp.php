<?php

//single responsibility principle (SRP) principio de responsabilidad unica ejemplo
// Este tipo de código es un ejemplo de cómo aplicar el principio de responsabilidad única (SRP) en PHP.

class Order
{
    private $items = [];
    private $total;

    public function  getTotal()
    {
        return $this->total;
    }

    public function addItem($description, $price)
    {
        $this->items[] = [
            'description' => $description,
            'price' => $price,
        ];
        $this->total += $price;
    }

    public function createOrder(){
        echo "Se procesa el pedido <br>" ;
    }

}

class EmailNotifier{
    public function send(Order $order){
        echo "Mensaje del pedido, total: ". $order->getTotal() . "<br>";
    }
}

$order = new Order();
$order->addItem('Producto 1', 100);
$order->addItem('Producto 2', 200);
$order->createOrder();

$emaiilNotifier = new EmailNotifier();
$emaiilNotifier->send($order);


