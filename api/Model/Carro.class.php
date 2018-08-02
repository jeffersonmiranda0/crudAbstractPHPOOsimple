<?php

require_once __DIR__. '/AbstractModel.class.php';


/**
 * @queryConfig {"schema":"Auth"}
 * @queryConfig {"table":"Carro3"}
 * @queryConfig {"namePk":"codigo"}
 * @classConfig {"ignore":"abc"}
 * @classConfig {"generateTable":true}
 */
class Carro extends AbstractModel{

    protected $table        = 'Carro';
    protected $schema       = 'Auth';
    protected $namePk       = 'codigo';

    protected $ignore       = Array();

    /**
     * @queryConfig {"name":"codigo"}
     * @queryConfig {"type":"int"}
     * @queryConfig {"notnull":true}
     * @queryConfig {"autoIncrement":"true"}
     * @queryConfig {"primaryKey":"true"}
     */
    protected $codigo;

    /**
     * @queryConfig {"name":"nome"}
     * @queryConfig {"type":"varchar(50)"}
     * @queryConfig {"default":"null"}
     */
    protected $nome;

    /**
     * @queryConfig {"name":"marca"}
     * @queryConfig {"type":"varchar(50)"}
     * @queryConfig {"default":"null"}
     */
    protected $marca;

    /**
     * @queryConfig {"name":"modelo"}
     * @queryConfig {"type":"varchar(50)"}
     * @queryConfig {"default":"null"}
     */
    protected $modelo;

    /**
     * @queryConfig {"name":"ano"}
     * @queryConfig {"type":"smallint(4)"}
     * @queryConfig {"default":"null"}
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
