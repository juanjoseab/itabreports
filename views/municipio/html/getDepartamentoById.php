<?php

MasterController::requerirClase("MysqlSelect");
$sl = new MysqlSelect();
if($_GET['itemId']){
    $sl->setTableReference("departamento");
    $sl->addSelection("departamento", "nombre");
    $sl->addFilter("departamento", "departamento_id", $_GET['itemId'], "="); 
    $sl->addSimpleLimit(1);
    
    if ( $sl->execute() ){
        if (count($sl->rows)){
            echo $sl->rows[0]['nombre'];
        }
    }
    
}
