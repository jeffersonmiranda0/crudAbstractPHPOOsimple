<?php

require_once __DIR__. '/AbstractModel.class.php';


/**
 * @classConfig {"schema":"Auth"}
 * @classConfig {"table":"Carro"}
 * @classConfig {"namePk":"codigo"}
 * @classConfig {"ignore":""}
 */
class Carro extends AbstractModel{

    protected $table        = 'Carro';
    protected $schema       = 'Auth';
    protected $namePk       = 'codigo';

    protected $ignore       = Array();

    /**
     * @classConfig {"name":"codigo"}
     * @classConfig {"type":"int"}
     * @classConfig {"default":"null"}
     * @classConfig {"autoIncrement":"true"}
     * @classConfig {"primaryKey":"true"}
     */
    protected $codigo;

    /**
     * @classConfig {"name":"nome"}
     * @classConfig {"type":"varchar(50)"}
     * @classConfig {"default":"null"}
     */
    protected $nome;

    /**
     * @classConfig {"name":"marca"}
     * @classConfig {"type":"varchar(50)"}
     * @classConfig {"default":"null"}
     */
    protected $marca;

    /**
     * @classConfig {"name":"modelo"}
     * @classConfig {"type":"varchar(50)"}
     * @classConfig {"default":"null"}
     */
    protected $modelo;

    /**
     * @classConfig {"name":"ano"}
     * @classConfig {"type":"smallint(4)"}
     * @classConfig {"default":"null"}
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
