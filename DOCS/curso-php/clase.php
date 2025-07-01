<?php
class Cancion{
    public string $titulo;
    public string $artista;


    public function reproducir(): string{
        return "Reproduciendo la canción: {$this->titulo} y es de {$this->artista}";
    }
}

$cancion  = new Cancion();

$cancion->titulo = "por dinero";
$cancion->artista="Juliano Sossa";

echo  $cancion->reproducir();