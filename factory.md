# Factory Method

O Factory Method (FM) é um padrão de projeto criacional que estabelece uma interface na superclasse para a criação de objetos, permitindo que as subclasses modifiquem o tipo de objetos a serem criados. Em termos simples, ele é empregado quando uma classe não pode prever a classe dos objetos que precisa criar. Isso confere flexibilidade ao processo de criação de objetos, permitindo que as subclasses determinem o tipo específico de objetos a serem instanciados.

## Problema :weary:
Imagine que você esteja criando um aplicativo que gerencia diversos tipos de documentos, como planilhas e apresentações. Agora, você está buscando criar um sistema que permita a flexibilidade na criação de objetos de leitores de documentos.
Neste contexto, existem diversos tipos de documentos, como os provenientes do Microsoft Excel e PowerPoint, e o objetivo é desenvolver leitores específicos para cada categoria de documento.

## Solução :satisfied:

O padrão FM sugere que substitua chamadas diretas de construção de objetos por chanadas para um método fábrica especial. Objetos retornados por um método fábrica geralmente são chamados de produtos.

```php
<?php

// 1. Definindo a interface do leitor de documentos com diferentes formatos
// A interface 'LeitorDocumento' é definida com um método 'ler()', garantindo que as classes que a implementam devem fornecer uma implementação para esse método.

interface LeitorDocumento {
    public function ler();
}

// 2. Implementando classes de leitores de documentos
// As três classes 'LeitorExcel', 'LeitorPowerPoint' e 'LeitorWord' implementam a interface 'LeitorDocumento', e fornecem uma implementação para o método 'ler()'.

class LeitorExcel implements LeitorDocumento {
    public function ler() {
        return "Lendo dados do Excel";
    }
}

class LeitorPowerPoint implements LeitorDocumento {
    public function ler() {
        return "Lendo slides do PowerPoint";
    }
}

class LeitorWord implements LeitorDocumento {
    public function ler() {
        return "Lendo texto do Word";
    }
}

// 3. Criando a fábrica abstrata para os leitores de documentos
// Aqui é definida uma interface 'FabricaLeitorDocumento' que exige que as classes que a implemente forneçam um método 'criarLeitor()'.

interface FabricaLeitorDocumento {
    public function criarLeitor();
}

// 4. Implementando fábricas concretas
// Classes 'FabricaLeitorExcel', 'FabricaLeitorPowerPoint' e 'FabricaLeitorWord' implementam a interface 'FabricaLeitorDocumento' e fornecem uma implementação para o método 'criarLeitor()'

class FabricaLeitorExcel implements FabricaLeitorDocumento {
    public function criarLeitor() {
        return new LeitorExcel();
    }
}

class FabricaLeitorPowerPoint implements FabricaLeitorDocumento {
    public function criarLeitor() {
        return new LeitorPowerPoint();
    }
}

class FabricaLeitorWord implements FabricaLeitorDocumento {
    public function criarLeitor() {
        return new LeitorWord();
    }
}

// 5. Utilizando o Factory Method
// A função 'processarDocumento' é definida que utiliza o FM para criar um leitor de documento e processar um documento.

function processarDocumento($fabrica) {
    $leitor = $fabrica->criarLeitor();
    return $leitor->ler();
}

// 6. Para imprimir
$fabricaExcel = new FabricaLeitorExcel();
$fabricaPowerPoint = new FabricaLeitorPowerPoint();
$fabricaWord = new FabricaLeitorWord();

echo processarDocumento($fabricaExcel) . "\n";      // Saída: "Lendo dados do Excel"
echo processarDocumento($fabricaPowerPoint) . "\n"; // Saída: "Lendo slides do PowerPoint"
echo processarDocumento($fabricaWord) . "\n";       // Saída: "Lendo texto do Word"

?>
```

Este exemplo demonstra como o Factory Method pode ser aplicado para criar leitores de documentos específicos, dependendo do tipo de documento que você precisa processar, mantendo a flexibilidade para adicionar novos tipos de leitores no futuro.

```mermaid
    classDiagram

    interface LeitorDocumento {
    +ler(): string
    }

    class LeitorExcel implements LeitorDocumento {
    +ler(): string
    }

    class LeitorPowerPoint implements LeitorDocumento {
    +ler(): string
    }

    class LeitorWord implements LeitorDocumento {
    +ler(): string
    }

    interface FabricaLeitorDocumento {
    +criarLeitor(): LeitorDocumento
    }

    class FabricaLeitorExcel implements FabricaLeitorDocumento {
    +criarLeitor(): LeitorExcel
    }

    class FabricaLeitorPowerPoint implements FabricaLeitorDocumento {
    +criarLeitor(): LeitorPowerPoint
    }

    class FabricaLeitorWord implements FabricaLeitorDocumento {
    +criarLeitor(): LeitorWord
    }

    class Cliente {
    +processarDocumento(FabricaLeitorDocumento): string
    }

    Cliente --> FabricaLeitorDocumento
    FabricaLeitorDocumento --> "1" LeitorDocumento
    FabricaLeitorDocumento <|-- "1" FabricaLeitorExcel
    FabricaLeitorDocumento <|-- "1" FabricaLeitorPowerPoint
    FabricaLeitorDocumento <|-- "1" FabricaLeitorWord
```