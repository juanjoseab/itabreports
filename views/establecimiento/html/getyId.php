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
        break;
        case 'tipos':
            if($_GET['itemId']){
                $sl->setTableReference("tipo");                
                if ( $sl->execute() ){
                    if (count($sl->rows)){
                        foreach($sl->rows AS $r){
                            echo '<option value="'.$r['tipo_establecimiento_salud_id'].'">'.$r['nombre'].'</option>';
                        }
                    }
                }

            }
            break;
    }
}






