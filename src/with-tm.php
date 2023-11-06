<?php

namespace classes\WithTm;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require "../vendor/autoload.php";

// Product
interface Dataset {
    public function abrirDataset(String $caminho);
    public function lerLinha(int $linha) : array;
}

class DatasetXlsx implements Dataset {

    protected Spreadsheet $spreadsheet;

    public function abrirDataset(String $caminho) {
        $this->spreadsheet = IOFactory::load($caminho);
    }
    
    public function lerLinha(int $linha) : array {
        $sheet = $this->spreadsheet->getActiveSheet();
        return array(
            $sheet->getCell('A'.$linha)->getValue(),
            $sheet->getCell('B'.$linha)->getValue(),
            $sheet->getCell('C'.$linha)->getValue()
        );
    }
}

class DatasetCsv implements Dataset {

    protected $file;

    public function abrirDataset(String $caminho) {

    }

    public function lerLinha(int $linha) : array {
        return array();
    }
}

// Creator
abstract class Gerenciador {

    protected String $caminho;

    public function __construct(String $caminho) {
        $this->caminho = $caminho;
    }

    public function cabecalho() : array {
        $gerenciador = $this->criarDataset();           // Instanciar dataset
        $gerenciador->abrirDataset($this->caminho);     // Abrir fluxo de leitura
        return $gerenciador->lerLinha(1);               // Ler colunas de cabeçalho
    }

    abstract public function criarDataset() : Dataset;
}

class GerenciadorXlsx extends Gerenciador {
    public function criarDataset() : Dataset {
        return new DatasetXlsx();
    }
}

class GerenciadorCsv extends Gerenciador {
    public function criarDataset(): Dataset {
        return new DatasetCsv();
    }
}

function gerenciarDataset(Gerenciador $creator) : void {
    echo "Cabeçalho: \n";
    echo var_dump($creator->cabecalho());
}

gerenciarDataset(new GerenciadorXlsx('data/dados.xlsx'));
