<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DepartamentoController
 *
 * @author webmaster
 */
class estandaresController extends Display {

    var $grid;
    var $rowsCount;

    function deploy() {
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "estandares";
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if (method_exists($this, $action)) {
                $this->$action();
            }
        }


        require_once P_THEME . DS . "index.php";
    }

    function deploySideMenu() {
        $this->sideMenu = "";

        $this->sideMenu .= '<div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Estandares</li>
              <li><a href="?v=estandares">Listar Estandares</a></li>
              <li><a href="?v=estandares&action=viewAgregar">Agregar Estandar</a></li>
              
              <li class="nav-header">Indicadores</li>
              <li><a href="?v=indicador">Listar indicadores</a></li>
              <li><a href="?v=indicador&action=viewAgregar">Agregar indicador</a></li>
              
              <li class="nav-header">Fechas</li>
              <li><a href="?v=fechas">Listar fechas</a></li>
              <li><a href="?v=fechas&action=viewAgregar">Agregar fecha</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->';
    }

    function createGrid($loadGrid = true) {
        MasterController::requerirClase("MysqlSelect");
        $mselect = new MysqlSelect();
        $mselect->setTableReference("estandar");
        //$mselect->addSelection($table, $select)
        //$mselect->addCustomSelection("municipio.*, departamento.nombre as departamento_nombre ");
        //$mselect->addJoin("departamento", "departamento_id", "=", "municipio", "departamento_id", "left");
        if ($_GET['filtro'] == 1) {
            if ($_POST['estandarId']) {
                $mselect->addFilter("estandar", "estandar_id", $_POST['estandarId'], "=");
            } elseif ($_GET['departamentoId']) {
                $mselect->addFilter("estandar", "estandar_id", $_GET['estandarId'], "=");
            }
        }

        //$mselect->addFilter("departamento", "estado", "1", "=");
        if ($_GET['pag'] > 0) {
            $pag = ($_GET['pag'] * ITEMSPERPAGE);
            $mselect->addComplexLimit($pag, ITEMSPERPAGE);
        } else {
            $mselect->addSimpleLimit(ITEMSPERPAGE);
        }

        if ($mselect->execute()) {
            $this->grid = $mselect->rows;
            if ($loadGrid) {
                $this->loadContentView("grid");
            }
        }

        $this->rowsCount = $mselect->rowsCount();
    }

    function getPaginacionPosition() {
        return ceil($this->rowsCount / ITEMSPERPAGE);
    }

    function getArrayPaginacion() {
        $totalpags = $this->getPaginacionPosition();
        if ($totalpags < 7) {
            $pags = Array();
            for ($i = 0; $i < $totalpags; $i++) {
                $pags[] = $i;
            }
            return $pags;
        } else {
            if ($_GET['pag'] > 3) {
                $initpage = $_GET['pag'] - 3;
                for ($i = $initpage; $i <= ($initpage + 1); $i++) {
                    $pags[] = $i;
                }
            } else {
                $pags = Array();
                for ($i = 0; $i < 7; $i++) {
                    $pags[] = $i;
                }
            }
            return $pags;
        }
    }

    function viewAgregar() {
        $this->loadContentView("viewAgregar");
    }

    function insert() {


        if (!$_POST) {
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("viewAgregar");
            return false;
        }

        if (!$_POST['nombre']) {
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }

        MasterController::requerirModelo("estandar");
        $item = new estandar();
        if ($_POST['nombre'] != '') {
            $item->nombre['val'] = $_POST['nombre'];
        }

        $item->estado['val'] = $_POST['estado'];


        $this->transaction->loadClass($item);

        if ($this->transaction->save()) {
            $this->done = true;
            $this->doneMsg = "Estandar {$_POST[nombre]} Agregado con exito";
            $this->loadContentView("viewAgregar");
            return true;
        }
    }

    function viewUpdateEstandarForm() {
        $this->loadContentView("updateEstandarForm");
    }

    function viewDetails() {
        $this->loadContentView("viewDetails");
    }

    function viewUpdateForm() {
        $this->loadContentView("updateForm");
    }

    function update() {
        //echo "<pre>"; print_r($_POST); echo "<pre>";


        if (!$_POST) {
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("default");
            return false;
        }

        if (!$_POST['nombre']) {
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("default");
            return false;
        }



        MasterController::requerirModelo("estandar");
        $item = new estandar();
        if ($_POST['estandar_id'] != '') {
            $item->estandar_id['val'] = $_POST['estandar_id'];
        }

        if ($_POST['nombre'] != '') {
            $item->nombre['val'] = $_POST['nombre'];
        }


        $item->estado['val'] = $_POST['estado'];


        $this->transaction->loadClass($item);

        //echo $this->transaction->update();
        if ($this->transaction->update()) {
            $this->done = true;
            $this->doneMsg = "Estandar {$_POST[nombre]} editado con exito";
            $this->loadContentView("default");
            return true;
        } else {
            $this->loadContentView("default");
            return false;
        }
    }

    function delete() {
        $id = $_GET['itemId'];
        MasterController::requerirModelo("estandar");
        $item = new estandar();
        $item->estandar_id['val'] = $id;
        $this->transaction->loadClass($item);
        if ($this->transaction->delete()) {
            $this->done = true;
            $this->doneMsg = "Estandar eliminado con exito";
            $this->loadContentView("default");
            return true;
        } else {
            $this->error = true;
            $this->doneMsg = "Error al eliminar el estandar";
            $this->loadContentView("default");
            return false;
        }
    }

    function addChild() {

        if ($_POST) {
            MasterController::requerirModelo("distrito_salud");
            $item = new distrito_salud();

            //nombre=asdf&codigo=asdf&departamentoNombre=Guatemala&departamento_id=1&estado=1
            if ($_POST['nombre'] != "") {
                $item->nombre['val'] = utf8_decode($_POST['nombre']);
            } else {
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El nombre no puede quedar vacio";
            }

            if ($_POST['municipio_id'] != "") {
                $item->municipio_id['val'] = $_POST['municipio_id'];
            } else {
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del municipio no puede quedar vacio";
            }


            if ($_POST['area_salud_id'] != "") {
                $item->area_salud_id['val'] = $_POST['area_salud_id'];
            } else {
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del area de salud no puede quedar vacio";
            }

            if ($_POST['estado'] != "") {
                $item->estado['val'] = $_POST['estado'];
            } else {
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del estado no puede quedar vacio";
            }



            $this->transaction->loadClass($item);
            if ($this->transaction->save()) {
                $this->done = true;
                $this->doneMsg = "Distrio de Salud {$_POST[nombre]} agregado con exito";
                //$this->loadContentView("default"); 
            } else {
                $this->error = true;
                $this->errorMsg = "<h4>Ooops!</h4>Error el ingreso, intentelo de nuevo";
            }
        } else {
            $this->error = true;
            $this->errorMsg = "<h4>Datos no recibidos!</h4>Error en el ingreso, intentelo de nuevo";
        }


        $this->loadContentView("resultadoAddChild");
        $this->getContentView();
        die;
    }

    function returnOptions() {
        $this->loadContentView("getById");
        $this->getContentView();
        die;
    }

}

?>
