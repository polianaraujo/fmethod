<?php

namespace classes\WithFm;

require "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Product
interface Leitor {
    public function abrirArquivo(String $caminho);
    public function lerLinha(int $linha) : array;
}

class LeitorXlsx implements Leitor {

    protected Spreadsheet $planilha;

    public function abrirArquivo(String $caminho) {
        $this->planilha = IOFactory::load($caminho);
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

class LeitorCsv implements Leitor {

    protected $arquivo;

    public function abrirArquivo(String $caminho) {
        $this->arquivo = fopen($caminho, "r");
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

// Creator
abstract class Documento {

    protected String $caminho;

    public function __construct(String $caminho) {
        $this->caminho = $caminho;
    }

    public function cabecalho() : array {
        $dataset = $this->criarLeitor();        // Instanciar dataset
        $dataset->abrirArquivo($this->caminho); // Abrir fluxo de leitura
        return $dataset->lerLinha(1);           // Ler colunas de cabeçalho
    }

    abstract public function criarLeitor() : Leitor;
}

class DocumentoXlsx extends Documento {
    public function criarLeitor() : Leitor {
        return new LeitorXlsx();
    }
}

class DocumentoCsv extends Documento {
    public function criarLeitor(): Leitor {
        return new LeitorCsv();
    }
}