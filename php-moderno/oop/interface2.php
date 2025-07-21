<?php

interface GetInfo{
    public function getInfo(): string;
}

class Address implements GetInfo{
    protected $address;

       public function __construct($address){
        $this->address = $address;
    }

    public function getInfo(): string{
        return $this->address;
    }

}

class WebSite implements GetInfo{
    protected $url;

    public function __construct($url){
        $this->url = $url;
    }

    public function getInfo(): string {
        return file_get_contents($this->url);
    }
}
 

function printInfo(GetInfo $site){
    echo $site->getInfo();
}

$address = new Address("Calle Falsa 123");
$webSite= new WebSite('https://hdeleon.net');
printInfo($address);
//printInfo($webSite);

