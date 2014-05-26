<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grid
 *
 * @author webmaster
 */
class Grid {
    
    /**
     * Indica el nombre del objeto del que se quiere crear una malla de datos.
     * @var String Indica el nombre del objeto del que se quiere crear una malla de datos.
     */
    
    private $object;
    
    
    /**
     * Inica el limite inicial de la seleccion de datos en la base de datos.
     * @var Integer
     */
    
    private $starts = 0;
    
    
    /**
     * Inica el limite final de la seleccion de datos en la base de datos.
     * @var Integer
     */
    
    private $ends = ITEMSPERPAGE;
    
  
    /**
     * almacena un arreglo de objetos con los datos de las tuplas que retorna un query a la base de datos.
     * @var Array<object>.
     */
    
    private $list;
    
    
    /**
     * almacena un arreglo con los datos de las tuplas que retorna un query a la base de datos.
     * @var Array
     */
    
    private $dataList;
    
    
    /**
     * 
     * @param type $param
     */
    
    function functionName($param) {
        
    }
    
    
    /**
     * @param Integer $init numero de tupla desde donde inicia a recolectar datos.
     * @return Boolean False si se envia un parametro no entero, de lo contrario True.
     */
    
    function setStarts($init){
        if(is_integer($init)){
            $this->starts = $init;
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * @param Integer $end numero de tuplas a recolectar desde el dato de inicio.
     * @return Boolean False si se envia un parametro no entero, de lo contrario True.
     */
    
    function setEnds($end){
        if(is_integer($end)){
            $this->ends = $end;
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * 
     * @param Object $object setea el objeto del que se construira la malla
     * @return Boolean False si se envia un parametro no entero, de lo contrario True.
     */
    
    function setObject(&$object){
        if(is_object($object)){
            $this->object = $object;
            return true;
        }else{
            return false;
        }
    }
    
    
    
    /**
     *      
     * @return Array<Object> Arreglo de objetos.
     */
    
    function getList(){
        return $this->list;
    }
    
    
    
    
    
    /**
     * Agrega un objeto al arreglo de objetos
     * @param Object $objet Objeto a agregar a la lista de objetos
     * @return false Si el parametro que pasa no es objeto
     * @return true si el parametro es un objeto valido
     */
    private function addItemList($objet){
        if(is_object($objet)){
            $this->list[] = $objet;
        }else{
            return false;
        }
    }
    
    
    /**
     * 
     * @param type $object el modelo del que se quiere constuir un lista
     * @param type $start desde que tupla de la tabla en la base de datos inicia la recoleccion de datos
     * @param type $end cuantas tuplas a partir del $start se deben recuperar de la tabla en la base de datos.
     */
    
    function createList(&$object=Null,$start=Null,$end=Null){
                
        /**
         * Si no esta seteado el objeto lo setea
         */
        if($object){
            $this->setObject($object);
        }
        
        /**
         * Setea el numero de la tupla inicial 
         */
        
        if($start){
            $this->setStarts($start);
        }
        
        
        /**
         * Setea la cantidad de tuplas a devolver
         */
        if($end){
            $this->setEnds($end);
        }
        
        /**
         * Verifica que todos los parametros necesarios existan para la creacion de la lista
         */
        if(!$this->object || $this->starts || !$this->ends){
            return false;
        }
        
        $modelName = get_class($this->object);
        
        MasterController::requerirClase("MysqlSelect");
        
        MasterController::requerirModelo($modelName);
        $sl =  new MysqlSelect();
        $sl->setTableReference($this->object->getReference());
        $sl->addComplexLimit($this->starts, $this->ends);
        $sl->execute();
        
        foreach($sl->rows AS $row => $r){
            $itemList = new $modelName();
            foreach ($r AS $field => $value){
                $functionName = "set" . str_replace(" ", "", ucwords(str_replace("_", " ", $field)) );
                if(method_exists($itemList, $functionName)){
                    $itemList->$functionName($value);
                }                
                $this->addItemList($itemList );
            }
        }
    }
    
    
    function getHtmlTable($attrId = Null, $attrClass = Null){
        if(!$this->object || !$this->list){
            return false;
        }
        
        
        $tableHtml = '<table '.( ($attrId != Null) ? 'id="'.$attrId.'" ' : "" ).'  '.( ($attrId != Null) ? 'class="'.$attrClass.'" ' : "" ).' >';
        
        $tableHtml .= '</table>';
        return $tableHtml;
    }
    
    
}

?>
















