<?php
if($_GET){
    MasterController::requerirClase("MysqlSelect");
    $sl = new MysqlSelect();
    switch ($_GET['referencia']){
        case 'municipios':
            if($_GET['itemId']){
                $sl->setTableReference("municipio");
                $sl->addSelection("municipio", "municipio_id");
                $sl->addSelection("municipio", "nombre");                
                $sl->addFilter("municipio", "departamento_id", $_GET['itemId'], "=");
                $sl->addFilter("municipio", "estado", 1, "=");
            if ( $sl->execute() ){
                if (count($sl->rows)){
                    foreach($sl->rows AS $r){
                        echo '<option value="'.$r['municipio_id'].'">'.$r['nombre'].'</option>';
                    }
                }
            }

        }
        
        case 'servicios':
            //echo 2;
            if($_GET['itemId']){
                $sl->setTableReference("servicio_intrahospitalario");                
                $sl->addFilter("servicio_intrahospitalario", "estandar_id", $_GET['itemId'], "=");
            if ( $sl->execute() ){
                if (count($sl->rows)){
                    echo '<option value="todos" selected="selected" >Todos los servicios</option>';
                    foreach($sl->rows AS $r){
                        echo '<option value="'.$r['servicio_intrahospitalario_id'].'">'.$r['nombre'].'</option>';
                    }
                }
            }

            }
            break;
        
        
        case 'indicadores':
            if($_GET['itemId']){
                $sl->setTableReference("indicador");
                $sl->addFilter("indicador", "estandar_id", $_GET['itemId'], "=");
                
                if ( $sl->execute() ){
                    if (count($sl->rows)){
                        ?> <option selected="selected" " value="0">Todos los indicadores</option> <?php
                        foreach($sl->rows AS $r){
                            ?> <option value="<?=$r['indicador_id']?>"><?=$r['nombre']?></option> <?php
                        }
                    }
                }
            }
            break;
        case 'indicadoresNotAll':
            if($_GET['itemId']){
                $sl->setTableReference("indicador");
                $sl->addFilter("indicador", "estandar_id", $_GET['itemId'], "=");
                
                if ( $sl->execute() ){
                    if (count($sl->rows)){                        
                        foreach($sl->rows AS $r){
                            ?> <option value="<?=$r['indicador_id']?>"><?=$r['nombre']?></option> <?php
                        }
                    }
                }
            }
            break;
        
        
        
        
    }
}
