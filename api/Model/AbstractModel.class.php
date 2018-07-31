<?php

/**
 * Description of AbstractModel
 *
 * @author jefferson
 */
require_once __DIR__ . '/../Service/ConnectionService.class.php';
require_once __DIR__ . '/../Service/ReturnService.class.php';
class AbstractModel extends ConnectionService{
    
    protected $workmodel;
    private $lastId = '';
    private $query  = '';
    
    public function __construct() {
        parent::__construct();
        
        $this->workmodel = $this;
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
    
    /**
     * RESPONSAVEL POR POPULAR OS ATRIBUTOS DA CLASSE
     * @return type
     */
    public function populateAttr()
    {
        $itensIgnore = array($this->workmodel->namePk, 'workmodel', 'table', 'schema', 'ignore', 'namePk', 'query', 'lastId');
        $namePk = $this->workmodel->namePk;
        
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
        $itensIgnore = array($this->workmodel->namePk, 'workmodel', 'table', 'schema', 'ignore', 'namePk', 'query', 'lastId');

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
        $itensIgnore = array($this->workmodel->namePk, 'workmodel', 'table', 'schema', 'ignore', 'namePk', 'query', 'lastId');

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


//    private function getConfigSchema()
//    {
//
//        $tokens = token_get_all(file_get_contents("example.php"));
//
//        foreach($tokens as $token) {
//            if($token[0] == T_COMMENT || $token[0] == T_DOC_COMMENT) {
//                $aux = preg_replace('/[ ]/ui', '', $token[1]);
//                $aux = preg_replace('/[\/*]/ui', '', $aux);
//                $aux = preg_replace('/[@]/ui', '"', $aux);
//                $aux = preg_replace('/[:]/ui', '":"', $aux);
//                $aux = preg_replace('/[}]/ui', '"}', $aux);
//
//                $this->setTable($aux);
//
//            }
//        }
//    }
//
//
//    private function setTable($value)
//    {
//        if(preg_match('/@Table/', $value)){
//            $value = json_decode($value);
//            $this->table = $value->Table;
//        }
//    }
    
}
