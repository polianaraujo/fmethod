<?php

require 'WithFm.php';

use classes\WithFm\{
    Documento,
    DocumentoXlsx
};

class Aplicacao {
    public static function run(Documento $doc) : void {
        echo var_dump($doc->cabecalho());
    }
}

$app = new Aplicacao;

$app::run(new DocumentoXlsx("data/dados.xlsx"));
