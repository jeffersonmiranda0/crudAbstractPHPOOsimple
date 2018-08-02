<?php
require_once __DIR__ . '/api/Model/Carro.class.php';

$carro = new Carro();
$carro->setCodigo("1"); //METODO SAVE -> SE ESTE VALOR ESTIVER SETADO ENTÃO REALIZA UPDATE, CASO NAO ESTEJA REALIZA INSERT
//$carro->setAno('2018');
//$carro->setMarca('VECTRA123 555d');
//$carro->setModelo("Expression insert");
//$carro->setNome('Besouro Negro');
//$retorno = $carro->save(true, $carro->getNome());

$retorno = $carro->populateAttr(); //METODO UTILIZADO PARA CARREGAR NA MEMÓRIA OS VALORES DE 1(UM) REGISTRO

//echo $carro->getNome() . '<br />';

//var_dump($retorno) . "<hr />";