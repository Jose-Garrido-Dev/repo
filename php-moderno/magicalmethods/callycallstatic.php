<?php

$engine = new Engine("log.txt");
$engine->error("Un error ocurrió");
$engine->log("El usuario ha hecho lo siguiente");
//$engine->run("name","some",true); // Llamando al método 'run' con todos los argumentos: 

//Engine::some();
class Engine{
    private $fileName;

    public function __construct($fileName){
        $this->fileName = $fileName;
    }

    // public function run(){
    //     echo "corre";
    // }

    public function __Call($name, $args){
        echo "Llamando al método '$name'"
        ."con todos los argumentos: " .implode(',',$args)."\n";
        $message = $name.": ";
        $message .= $args[0]. " - ";
        $message .= date("Y-m-d H:i:s")."\n";
    // Aqui con esta funcion se guarda el mensaje en el archivo
        if(!file_exists($this->fileName)){
            file_put_contents($this->fileName,"");
        }
        //file_append es una funcion que permite agregar contenido al final del archivo
        file_put_contents($this->fileName, $message, FILE_APPEND);
    }

    public static function __CallStatic($name, $args){
        echo "Llamando al método '$name'"
        ."con todos los argumentos: " .implode(',',$args)."\n";
    }
}
