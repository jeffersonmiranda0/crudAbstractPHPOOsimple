<?php 
/**
 * @author JEFERSON MIRANDA
 */

class ConnectionService
{
    private $server         = "localhost";
    private $user           = "root";
    private $password       = "";
    private $database       = "auth";
    private $sql            = "";
    private $connection     = NULL;


    public function __construct()
    {
        $this->connection = $this->setConnect();
    }

    public function __destruct()
    {
        if($this->connection != NULL):
            $this->connection   = NULL;
            $this->sql          = "";
        endif;
    }
    
    public function request()
    {
        return $this->connection;
    }

    
    private function setConnect()
    {
        try {
            $connection = new PDO("mysql:host=$this->server;dbname=$this->database", $this->user, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //SETA TABELA COMO UTF8
            $connection->query("SET NAMES 'utf8'");
            $connection->query("SET character_set_connection=utf8");
            $connection->query("SET character_set_client=utf8");
            $connection->query("SET character_set_results=utf8");
            
        } catch (PDOException $e) {
            echo "Ops Ocorreu um erro: " . $e->getMessage();
        }
        
        //Retorna a conexão com o banco
        return $connection;
    }

    public function lastInsertId(){
        return $this->connection->lastInsertId();
    }


    public function setBindParam($stmt, $values)
    {

        foreach($values as $key => $value)
        {
            $stmt->bindParam(":{$value['param']}", $value['val'], SELF::getParam($value['val']));
        }

        return $stmt;

    }

    private function getParam($value){

        if(gettype($value) == 'int') return PDO::PARAM_INT;
        if($value == 'NULL') return PDO::PARAM_NULL;
        return PDO::PARAM_STR;

    }

}