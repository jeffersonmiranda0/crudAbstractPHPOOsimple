<?php
/**
 * Created by PhpStorm.
 * User: jefferson
 * Date: 01/08/2018
 * Time: 21:28
 */

class ReadDoc
{
    private $supportAnnotation  = ['queryConfig', 'classConfig'];
    private $property           = Array();

    /**
     * @return array
     */
    public function getProperty()
    {
        return $this->property;
    }


    public function read($global)
    {
        $docs        = self::getReflectionClass($global);

        /**
         * LE A CONFIG DA CLASSE
         */
        self::getReflectionProperty($docs['docComment'], 'header', true);

        foreach ($docs['property'] as $doc){
            self::getReflectionProperty($doc->class, $doc->name);
        }
        return $this->property;

    }


    public function getReflectionProperty($class, $property, $comment = false)
    {
        $docComment = $class;

        foreach ($this->supportAnnotation as $annotation){

            if($comment == false){
                $reflection = new ReflectionProperty($class, $property);
                $docComment = $reflection->getDocComment();
            }

            self::setProperty(self::searchAnnotation($annotation, $docComment), $annotation, $property);
        }
    }


    public function searchAnnotation($annotation, $docComment)
    {
        $listProperty = Array();
        preg_match_all("/@$annotation (.*?)\n/", $docComment, $listProperty);
        return $listProperty;
    }



    public function setProperty(Array $docComment, $annotation, $property)
    {
        if(count($docComment[1]) <= 0) return;
        $this->property[$annotation][$property] = self::transformJsonInArray($docComment[1]);
    }


    public static function getReflectionClass($global)
    {
        $class      = get_class($global);
        $reflect    = new ReflectionClass($class);
        return [
            "property"      => $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED),
            "docComment"    => $reflect->getDocComment()
        ];
    }


    private function transformJsonInArray($doc)
    {
        $values     = array_map('trim', $doc);
        $newArray   = Array();

        foreach ($values as $value){
            $aux = json_decode($value);

            if($aux == null) continue;

            $aux = get_object_vars($aux);

            foreach ($aux as $i => $v){
                $newArray[$i] = $v;
            }

        }

        return $newArray;
    }

}