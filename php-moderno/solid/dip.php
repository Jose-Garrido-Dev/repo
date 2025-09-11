<?php

// El principio de dependencia de inversión (DIP) establece que las clases de alto nivel no deben depender de las clases de bajo nivel, ambas deben depender de abstracciones (interfaces).

interface ReportInterface{
    public function generate(string $content) : string;
}

class PDFReport implements ReportInterface{
    public function generate(string $content) : string {
        // Generar informe en PDF
        echo "Se crea pdf con el contenido: $content";
    }
}

class HTMLReport implements ReportInterface{
    public function generate(string $content) : string {
        // Generar informe en HTML
        echo "Se crea html con el contenido: $content";
    }
}

class Estimate{
    private ReportInterface $report;

    public function __construct(ReportInterface $report) // es mejor pasarlo ya creado en el constructor
    {
        $this->report = $report;
    }

    public function process(){
        echo "Se genera la estimación<br>";
        $this->report->generate("Contenido de la estimación");
    }
}


$pdfReport = new PDFReport();
$htmlReport = new HTMLReport();
//$estimate = new Estimate($pdfReport);
$estimate = new Estimate($htmlReport);
$estimate->process();