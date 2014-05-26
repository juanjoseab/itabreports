<?php

class MasterModel {
    public function __construct() {
        MasterController::requerirClase("MysqlSelect");
    }
    
    function getGatalogo($table,array $selection, array $filter,$limit){       
        $ms = new MysqlSelect();
        $ms->setTableReference($table);
        if(count($selection)>0){
            foreach ($selection as $item){
                $ms->addSelection($table, $item);
                
            }
        }
        
        if(count($filter)>0){
            
            foreach ($filter as $f){                
                $ms->addFilter($table, $f['field'], $f['compareValue'], $f['exp']);
            }
            
            
        }
        
        if($limit){
            $ms->addSimpleLimit($limit);
        }
        
        $sql = $ms->returnQuery();
        
        $dbo = new Dbexec();        
        $dbo->queryExecute($sql);
        
        
        
    }
    
    
}
?>
