# Factory Method

O Factory Method (FM) é um padrão de projeto criacional que estabelece uma interface na superclasse para a criação de objetos, permitindo que as subclasses modifiquem o tipo de objetos a serem criados. Em termos simples, ele é empregado quando uma classe não pode prever a classe dos objetos que precisa criar. Isso confere flexibilidade ao processo de criação de objetos, permitindo que as subclasses determinem o tipo específico de objetos a serem instanciados.

## Problema
Imagine que você esteja criando um aplicativo que gerencia diversos tipos de documentos, como planilhas e apresentações. Agora, você está buscando criar um sistema que permita a flexibilidade na criação de objetos de leitores de documentos.
Neste contexto, existem diversos tipos de documentos, como os provenientes do Microsoft Excel e PowerPoint, e o objetivo é desenvolver leitores específicos para cada categoria de documento.

## Solução

Este exemplo demonstra como o Factory Method pode ser aplicado para criar leitores de documentos específicos, dependendo do tipo de documento que você precisa processar, mantendo a flexibilidade para adicionar novos tipos de leitores no futuro.

O padrão FM sugere que substitua chamadas diretas de construção de objetos por chanadas para um método fábrica especial. Objetos retornados por um método fábrica geralmente são chamados de produtos.

 As subclasses de Documento disponibilizam um método responsável por instanciar o leitor responsável por lidar com o tipo de documento relacionada a elas


