<?php

/**
 * Description of AbstractModel
 *
 * @author jefferson
 */
require_once __DIR__ . '/../Service/ConnectionService.class.php';
require_once __DIR__ . '/../Service/ReturnService.class.php';
require_once __DIR__ . '/../Service/ReadDoc.php';
class AbstractModel extends ConnectionService{
    
    public $workmodel;
    private $lastId         = '';
    private $query          = '';
    private $classConfig    = Array();
    private $ignoreAttr     = array('workmodel', 'table', 'schema', 'ignore', 'namePk',
        'query', 'lastId', 'config', 'ignoreAttr', 'classConfig'
    );
    
    public function __construct() {
        parent::__construct();
        
        $this->workmodel    = $this;
        $this->classConfig  = (new ReadDoc())->read($this->workmodel);
        $this->createTable();
    }
    
    
    /**
     * RESPONSAVEL POR RETORNAR O LASTID
     * @return type
     */
    function getLastId() {
        return $this->lastId;
    }
    
    /**
     * RESPONSAVEL POR RETORNAR A QUERY CASO O DESENVOLVEDOR SOLICITE
     * @return type
     */
    function getQuery() {
        return $this->query;
    }
            
    /**
     * RESPONSAVEL POR EXECUTAR A QUERY E RETORNAR LISTAGEM
     * @param type $query
     * @return type
     */
    public function localiza($query)
    {
        return $this->request()->query($query, PDO::FETCH_ASSOC)->fetch(PDO::FETCH_OBJ);
    }


    private function createTable()
    {
        if($this->classConfig['classConfig']['header']['generateTable'] == 0 || !isset($this->classConfig['classConfig']['header']['generateTable'])) return;
        if(!isset($this->classConfig['queryConfig'])) return;


        $table = $this->classConfig['queryConfig']['header']['table'];
        $attrs = Array();

        foreach ($this->classConfig['queryConfig'] as $name => $config){
            if($name == 'header') continue;

            $name           = $config['name'];
            $type           = $config['type'];
            $autoIncrement  = isset($config['autoIncrement']) ? " AUTO_INCREMENT " : "";
            $primaryKey     = isset($config['primaryKey']) ? " PRIMARY KEY " : "";
            $notnull        = (isset($config['notnull']) and $config['notnull'] == true) ? "NOT NULL" : "";
            $default        = isset($config['default']) ? " DEFAULT {$config['default']} " : "";
            $comment        = isset($config['comment']) ? " COMMENT({$config['comment']}) " : "";

            $attrs[] = ("$name $type $notnull $autoIncrement $primaryKey $default $comment\n");
        }


        $query = "CREATE TABLE IF NOT EXISTS {$table} (". implode($attrs, ' , ') .")";
        $this->request()->query($query);
        $this->query = $query;
    }

    
    /**
     * RESPONSAVEL POR POPULAR OS ATRIBUTOS DA CLASSE
     * @return type
     */
    public function populateAttr()
    {
        $itensIgnore    = $this->ignoreAttr;
        $itensIgnore[]  = $this->workmodel->namePk;
        $itensIgnore    = $this->ignoreAttr;
        $namePk         = $this->workmodel->namePk;
        
        $header = Array();
        
        foreach ($this->workmodel as $attr => $val) {
            if (in_array($attr, $itensIgnore)) { continue; }    
            $header[] = $attr;
        }
        
        $this->query = "SELECT " . implode(', ', $header) . " 
                        FROM {$this->workmodel->schema}.{$this->workmodel->table}
                        WHERE {$this->workmodel->namePk} = :{$this->workmodel->namePk}";
        $smtp = $this->request()->prepare($this->query);
        $smtp->bindParam(":{$this->workmodel->namePk}", $this->workmodel->$namePk, PDO::PARAM_INT);
        $smtp->execute();
        $row = $smtp->fetch(PDO::FETCH_ASSOC);
        
        if($row){
            
            foreach ($row as $key => $value){
                
                $newKey = 'set' . ucfirst($key);
                $this->$newKey($value);
                
            }
            
            return ReturnService::requestStatus('Populado!', true);
            
        }
        
        
        return ReturnService::requestStatus('Não foi possível localizar o registro!', FALSE, $row);
    }
    
    /**
     * METODO ABSTRATO QUE REALIZA A INSERÇÃO NO BANCO
     * @param bool $saveEmpty
     * @return type
     */
    public function insert($saveEmpty = false)
    {
        $itensIgnore    = $this->ignoreAttr;
        $itensIgnore[]  = $this->workmodel->namePk;
        $itensIgnore    = $this->ignoreAttr;

        $name   = Array();
        $values  = Array();

        foreach ($this->workmodel as $attr => $val) {

            if (in_array($attr, $itensIgnore)) { continue; }
            if (in_array($attr, $this->workmodel->ignore)) { continue; }
            if($saveEmpty == true AND trim($val) == ''){ continue; }

            $name[]  = $attr;
            $param[] = ":$attr";
            $values[] = SELF::values($attr, $val);
        }

        $names  = implode(', ', $name);
        $params  = implode(', ', $param);

        $this->query = "INSERT INTO {$this->workmodel->schema}.{$this->workmodel->table} ($names) VALUES ($params)";
        $stmt = $this->request()->prepare($this->query);
        $stmt = SELF::setBindParam($stmt, $values);
        $stmt->execute();

        $this->lastId = $this->request()->lastInsertId();

        return ReturnService::requestStatus('Registro Inserido com sucesso!', true);
    }


    /**
     * METODO PARA ATUALIZAR REGISTRO
     * @param bool $saveEmpty
     * @return type
     */
    public function update($saveEmpty = false)
    {
        $itensIgnore    = $this->ignoreAttr;
        $itensIgnore[]  = $this->workmodel->namePk;
        $itensIgnore    = $this->ignoreAttr;

        $name   = Array();
        $values = Array();

        foreach ($this->workmodel as $attr => $val) {

            if (in_array($attr, $itensIgnore)) { continue; }
            if (in_array($attr, $this->workmodel->ignore)) { continue; }
            if($saveEmpty == true AND trim($val) == ''){ continue; }

            $name[]     = "$attr = :$attr \n";
            $values[]   = SELF::values($attr, $val);
        }

        $names  = implode(', ', $name);

        $this->query = "UPDATE {$this->workmodel->schema}.{$this->workmodel->table} 
                        SET    $names 
                        WHERE  {$this->workmodel->namePk} = {$this->workmodel->{$this->workmodel->namePk}}";
        $stmt = $this->request()->prepare($this->query);
        $stmt = SELF::setBindParam($stmt, $values);
        $stmt->execute();

        $this->lastId = $this->workmodel->{$this->workmodel->namePk};

        return ReturnService::requestStatus('Registro Atualizado com sucesso!', true);
    }


    /**
     * @param bool $saveEmpty
     * @param null $callback
     * @return array|type
     */
    public function save($saveEmpty = false, $callback = null)
    {
        if((int)$this->workmodel->{$this->workmodel->namePk} > 0){
            $retorno = $this->update($saveEmpty);
        } else {
            $retorno = $this->insert($saveEmpty);
        }

        if($callback <> null){

            if(gettype($callback) == 'object'){
                /** @var callable $callback */
                $retorno['callback'] = $callback();
            }

            $retorno['callback'] = $callback;
        }

        return $retorno;
    }


    /**
     * RETORNA OS VALORES CORRETAMENTE
     * @param $param
     * @param $value
     * @return array
     */
    private function values($param, $value)
    {
        
        $val = $value;

        if (is_numeric($val) == true) {

            if (gettype($val) == 'integer') {
                return ["param" => $param, "val" => $val, "type" => 'int'];
            }

            return ["param" => $param, "val" => $val, "type" => 'float'];

        }

        if ($val == NULL) {
            return ["param" => $param, "val" => $val, "type" => 'null'];
        }

        return ["param" => $param, "val" => $val, "type" => 'string'];
            
    }





    public function getProperty()
    {
//        $class = get_class($this->workmodel);
//        $matchesnew = Array();
//        $property = get_class_vars($class);
//
//
//        require_once "api/Service/ReadDoc.php";
//
//
//        $read = new ReadDoc($this);
//
//        return $read->read($this->workmodel);




//        foreach ($property as $nameprop => $prop){
//
//            if(in_array($nameprop, $this->ignoreAttr)) continue;
//            echo '<pre>';
////            var_dump($nameprop);
//
//            $rc = new ReflectionProperty($class, $nameprop);
////            var_dump($rc->getDocComment());
//            preg_match_all("/@ConfigTable (.*?)\n/", $rc->getDocComment(), $matches);
//            $matchesnew[] = array_map('trim', $matches[1]);
//
//        }
//
//
//        $rf = new ReflectionClass($class);
//        preg_match_all("/@ConfigTable (.*?)\n/", $rf->getDocComment(), $matches2);
//        $matches2 = array_map('trim', $matches2[1]);
//
//
//
//        return [
//            "cabecalho" => $matches2,
//            "attr"      => $matchesnew
//        ];

    }

}
