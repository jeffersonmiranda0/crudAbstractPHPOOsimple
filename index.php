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





$rc = new ReflectionClass(new Carro());
$tokens = token_get_all(file_get_contents($rc->getFileName()));

$count = 0;
$index = Array();
foreach($tokens as $token) {
    if($token[0] == T_DOC_COMMENT) {
//        var_dump($token[1]);
        $aux = $token[1];
        $aux = preg_replace('/[\/*"]/ui', '', $aux);
        $aux = explode(' ', $aux);

        foreach ($aux as $value){
            if(trim($value) <> ''){
                $index[$count][] = trim($value);
            }
        }

    }
    $count++;
}

//echo "<pre>";
//var_dump($index);
//
//
//echo "</pre>";
//
//echo "<br />";

//$rc = new ReflectionProperty($carro, 'index');
//var_dump($rc->getDocComment());
//
//$class = new ReflectionClass($carro);
//$property = $class->getProperty('codigo')->getDocComment();
//
//var_dump($property);


var_dump($carro->getProperty());


//var_dump($rc);


