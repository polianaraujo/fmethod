<?php

require 'NoFm.php';

use classes\NoFm\{
    Documento,
    DocumentoXlsx,
    DocumentoCsv
};

class Aplicacao {
    public static function run(Documento $doc) : void {
        echo var_dump($doc->cabecalho());
    }
}

$app = new Aplicacao;

$app::run(new DocumentoXlsx("data/dados.xlsx"));
