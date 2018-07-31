<?php

require_once __DIR__. '/AbstractModel.class.php';

class Carro extends AbstractModel{
    
    protected $table    = 'Carro';
    protected $schema   = 'Auth';
    protected $namePk   = 'codigo';

    protected $ignore   = Array();
    
    protected $codigo;
    protected $nome;
    protected $marca;
    protected $modelo;
    protected $ano;

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getAno() {
        return (int)$this->ano;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setAno($ano) {
        $this->ano = (int)$ano;
    }
    
}
