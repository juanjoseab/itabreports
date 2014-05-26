<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MysqlSelect
 *
 * @author webmaster
 */

class MysqlSelect {
    var $distinct = false;
    var $selection = array();
    var $customSelection = array();
    var $table_reference = false;
    var $join  = array();
    var $filter = array();    
    var $group  = array();
    var $having  = array();    
    var $order  = array();
    var $limit = FALSE;
    
    var $query = "";
    var $rows = array();
    
    public function __construct() {
        ;
    }
    
    function setDistinct(){
        $this->distinct = true;
    }
    
    function addSelection($table,$select,$alias=false){
        $selection = array("table"=>$table, "selection"=>$select,"alias"=>$alias);
        $this->selection[]=$selection;
    }
    
    function addCustomSelection($customSelect){        
        $this->customSelection[]=$customSelect;
    }
    
    
    function setTableReference($table){
        $this->table_reference=$table;
    }
    
    function addJoin($table,$field,$expression,$compareTable,$compareField,$type = "INNER"){
        $join = array("table"=>$table, "field"=>$field, "exp"=>$expression, "compareTable"=>$compareTable, "compareField"=>$compareField, "type" => $type);
        $this->join[]=$join;
    }
    
    
    function addFilter($table,$field,$compareValue,$exp){
        $filter = array("table" => $table, "field" => $field, "compareValue" => $compareValue,"exp" => $exp);
        $this->filter[]= $filter;
    }
    
	function addCustomFilter($customFilter){        
        $this->customFilter[]= $customFilter;
    }
    
    function addGroup($table,$field){
        $group = Array ("table"=>$table, "field"=>$field);
        $this->group[]=$group;
    }
    
    
    function addHaving($table,$col,$experession,$compareValue){
        
        if(count($this->group)>0){
            $existInGruping = FALSE;
            foreach ($this->group AS $gr){
                if($gr['table']==$table && $gr['field']==$col){
                    $existInGruping = TRUE;
                }
            }
        }
        
        if($existInGruping){
            $having = Array("table" => $table, "column" => $col, "exp" => $experession, "value" => $compareValue);
            $this->having[]=$having;
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    function addOrderBy($table,$field,$type = ""){
        $order = array("table" => $table, "field" => $field, "type" => $type);
        $this->order[]=$order;
    }
    
    function addSimpleLimit($limit){
        $this->limit=$limit;
    }
    
    function addComplexLimit($start,$rows){
        $this->limit=array("start" => $start, "rows" => $rows);
    }
    
    function returnQuery($numRows=false){
        $this->query = "
                    SELECT ";
        if($this->distinct){
            $this->query .= "DISTINCT ";
        }
        
        if(count($this->selection) > 0){
            //$selection = array("table"=>$table, "selection"=>$select, "alias"=>$alias);
            foreach ($this->selection AS $select){
                $this->query .= "{$select['table']}.{$select['selection']}";
                if($select['alias']){
                    $this->query .= " AS {$select[alias]}, ";
                }else{
                    $this->query .= ", ";
                }
            }
            $this->query = substr($this->query, 0,-2);
        }
        
        if(count($this->customSelection) > 0){
            if(count($this->selection) > 0){$this->query .= ", ";}
            foreach ($this->customSelection AS $custom){
                $this->query .= " {$custom}, ";
            }
            $this->query = substr($this->query, 0,-2);
        }
        
        if(count($this->selection) < 1 && count($this->customSelection)< 1){
            
            $this->query .= " * ";
        
        }
        
        
        if($this->table_reference){
            $this->query .= " 
                    FROM {$this->table_reference} ";
        }else{
            return false;
        }
        
        
        if(count($this->join) > 0){
            foreach ($this->join AS $join){
                //$join = array("table"=>$table, "field"=>$field, "exp"=>$expression, "compareTable"=>$compareTable, "compareField"=>$compareField, "type" => $type);
                $this->query .= "   
                        {$join[type]} JOIN {$join[table]} 
                            ON {$join[table]}.{$join[field]} {$join[exp]} {$join[compareTable]}.{$join[compareField]} 
                            ";
            }
            
        }
        
        if(count($this->filter) > 0){
            $this->query .= "   
                        WHERE ";
            foreach ($this->filter AS $filter){
                //$filter = array("table" => $table, "field" => $field, "compareValue" => $compareValue,"exp" => $exp);
                $this->query .= " {$filter[table]}.{$filter[field]} {$filter[exp]} '{$filter[compareValue]}' AND";
            }
            $this->query = substr($this->query, 0,-3);
        }
        
        if(count($this->customFilter) > 0){
            if(count($this->filter) > 0){$this->query .= "OR ";}else{ $this->query .= " WHERE "; }
            foreach ($this->customFilter AS $custom){
                $this->query .= " {$custom}, ";
            }
            $this->query = substr($this->query, 0,-2);
        }
        
        if(count($this->group) > 0){
            $this->query .= "   
                        GROUP BY ";
            foreach ($this->group AS $group){                
                $this->query .= " 
                            {$group[table]}.{$group[field]},";
            }
            $this->query = substr($this->query, 0,-1);
        }
        
        if(count($this->having) > 0){
            //$having = Array("table" => $table, "column" => $col, "exp" => $experession, "value" => $compareValue);
            $this->query .= "   
                        HAVING ";
            foreach ($this->having AS $have){                
                $this->query .= " {$have[table]}.{$have[column]} {$have[exp]} '{$have[value]}' AND";
            }
            $this->query = substr($this->query, 0,-3);
        }
        
        if(count($this->order) > 0){
            //$order = array("table" => $table, "field" => $field, "type" => $type);
            $this->query .= "   
                        ORDER BY ";
            foreach ($this->order AS $order){                
                $this->query .= " 
                                {$order[table]}.{$order[field]} {$order[type]},";
            }
            $this->query = substr($this->query, 0,-1);
        }
        
        if($numRows == false){
            $this->addLimitToQuery($this->query);
        }
        
       
         $this->query .= ";";
         return $this->query;
    }
    
    function addLimitToQuery(&$query){
         if($this->limit && is_array($this->limit)){
            
            $query .= "   
                        LIMIT {$this->limit[start]}, {$this->limit[rows]}";            
        }elseif($this->limit){
            $query .= "   
                        LIMIT {$this->limit}";
        }
    }
    
    
    function rowsCount(){
        $dbo = new Dbexec();
        $dbo->queryExecute($this->returnQuery(TRUE));
        if($dbo->error){
                echo '<div class="alert">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Alerta!</strong>'.$dbo->error.'</div>';
                return false;
            }else{
                
                return $dbo->numeroFilas();
            }
    }
    
    
    
    function execute(){
        if($this->returnQuery()){
            //print( $this->returnQuery() ."<br />");
            $dbo = new Dbexec();
            $dbo->queryExecute($this->returnQuery());
            if($dbo->error){
                echo '<div class="alert">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Alerta!</strong>'.$dbo->error.'<br />'.$this->returnQuery().'</div>';
                return false;
            }else{
                while($r = $dbo->getArray()){
                    $this->rows[] = $r;
                }
                
                return true;
            }
        }else{
            return false;
        }
        
        
    }
    
    
    
}

?>
