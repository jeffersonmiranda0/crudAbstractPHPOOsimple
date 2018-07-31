<?php
require_once __DIR__ . '/api/Model/Carro.class.php';

$carro = new Carro();
$carro->setCodigo("1");
//$carro->setAno('2018');
//$carro->setMarca('VECTRA123 555d');
//$carro->setModelo("Expression insert");
//$carro->setNome('Besouro Negro');
//$retorno = $carro->save(true, $carro->getNome());
$retorno = $carro->populateAttr();

echo $carro->getNome() . '<br />';

var_dump($retorno);