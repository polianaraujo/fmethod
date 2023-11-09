<?php

namespace classes\NoFm;

require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

abstract class Documento {
    protected string $caminho;
    public function __construct(String $caminho) {
        $this->caminho = $caminho;
    }

    public function cabecalho() : array {
        $this->abrirArquivo();
        return $this->lerLinha(1);
    }

    abstract public function abrirArquivo();
    abstract public function lerLinha(int $linha) : array;
}

class DocumentoXlsx extends Documento {
    protected Spreadsheet $planilha;

    public function abrirArquivo() {
        $this->planilha = IOFactory::load($this->caminho);
    }
    
    public function lerLinha(int $linha) : array {
        $sheet = $this->planilha->getActiveSheet();
        return array(
            $sheet->getCell("A".$linha)->getValue(),
            $sheet->getCell("B".$linha)->getValue(),
            $sheet->getCell("C".$linha)->getValue()
        );
    }
}

class DocumentoCsv extends Documento {
    protected $arquivo;

    public function abrirArquivo() {
        $this->arquivo = fopen($this->caminho, "r");
    }

    public function lerLinha(int $linha) : array {  
        $linhaAtual = $linha;
        while( ($dados = fgetcsv($this->arquivo, null, ",")) !== false) {
            if ($linhaAtual == $linha) {
                return $dados;
            }
            $linhaAtual++;
        }
        return array();
    }
}