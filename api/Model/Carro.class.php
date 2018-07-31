<?php

require_once __DIR__. '/AbstractModel.class.php';

class Carro extends AbstractModel{

    protected $table        = 'Carro';
    protected $schema       = 'Auth';
    protected $namePk       = 'codigo';

    protected $ignore       = Array();

    protected $config       = Array(
        "createTable" => true
    );

    /**
     * @var int $codigo
     */
    protected $codigo;
    /**
     * @var string $nome;
     */
    protected $nome;
    /**
     * @var string $marca
     */
    protected $marca;
    /**
     * @var string $modelo
     */
    protected $modelo;
    /**
     * @var int $ano
     */
    protected $ano;


    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param string $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param string $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * @return int
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param int $ano
     */
    public function setAno($ano)
    {
        $this->ano = $ano;
    }
}
