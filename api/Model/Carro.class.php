<?php

require_once __DIR__. '/AbstractModel.class.php';


/**
 * @Schema (Auth)
 * @Table (Carro5)
 * @NamePk (codigo)
 * @Ignore (abc)
 * @GenerateTable (true)
 */
class Carro extends AbstractModel{

    protected $table        = 'Carro';
    protected $schema       = 'Auth';
    protected $namePk       = 'codigo';

    protected $ignore       = Array();

    /**
     * @var $codigo
     * @Column (codigo)
     * @Type (INT)
     * @NotNull (true)
     * @Increment (true)
     * @PrimaryKey (true)
     * @Default (NULL)
     * @Comment (Primary Key)
     */
    protected $codigo;

    /**
     * @var $nome
     * @Column (nome)
     * @Type (VARCHAR)
     * @Length (50)
     * @NotNull (true)
     */
    protected $nome;

    /**
     * @var $marca
     * @Column (marca)
     * @Type (VARCHAR)
     */
    protected $marca;

    /**
     * @var $modelo
     * @Column (modelo)
     * @Type (VARCHAR)
     * @Length (50)
     * @NotNull (true)
     */
    protected $modelo;

    /**
     * @var $ano
     * @Column (ano)
     * @Type (SMALLINT)
     * @Length (4)
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
