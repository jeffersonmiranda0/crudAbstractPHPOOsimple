<?php

/**
 * Description of ModelTeste
 *
 * @author jefferson
 */
require_once __DIR__ . '/AbstractModel.class.php';
abstract class ModelTeste extends AbstractModel{

    protected $table      = 'pessoa';
    protected $schema     = 'auth';
    protected $namePk     = 'codigo';
    protected $ignore     = Array();

    protected $codigo;
    protected $nome;
    protected $sobrenome;
    protected $ativo;

    function getCodigo() {
        return $this->codigo;
    }

    function getNome() {
        return $this->nome;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function getAtivo() {
        return $this->ativo;
    }

    function setCodigo($codigo) {
        $this->codigo = (int)$codigo;
    }

    function setNome($nome) {
        $this->nome = (string)$nome;
    }

    function setSobrenome($sobrenome) {
        $this->sobrenome = (string)$sobrenome;
    }

    function setAtivo($ativo) {
        $this->ativo = (int)$ativo;
    }

    public function __construct() {
        parent::__construct($this);

    }
    
}
