<?php

interface SendInterface{
    public function send(string $message);
}

interface SaveInterface{
    public function save();
}

class Document implements SendInterface, SaveInterface{
    public function send(string $message)
    {
        echo "Enviando venta: $message\n";
    }

    public function save()
    {
        echo "guardando venta nube\n";
    }
}

class BeerRepository implements SaveInterface{
    public function save()
    {
        echo "Se guarda en una BD";
    }
}

class SaveProcess{
    private SaveInterface $saveManager;

    public function __construct(SaveInterface $saveManager)
    {
        $this->saveManager = $saveManager;
    }

    public function keep()
    {
        echo "Hacemos algo antes de guardar\n";
        $this->saveManager->save();
    }
}

$beerRepository = new BeerRepository();
$document = new Document();
$saveProcess = new SaveProcess($beerRepository);
$saveProcess->keep();

