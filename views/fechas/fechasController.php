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
class fechasController extends Display {

    var $grid;
    var $rowsCount;

    function deploy() {
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "fechas";
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
        $mselect->setTableReference("fecha");
        $mselect->addOrderBy("fecha", "anio", "DESC");
        $mselect->addOrderBy("fecha", "mes", "DESC");

        if ($_GET['filtro'] == 1) {
            if ($_POST['estandarId']) {
                $mselect->addFilter("fecha", "fecha_id", $_POST['fecha_id'], "=");
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

        if (!$_POST['anio'] || !$_POST['mes'] ) {
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Todos los campos son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }

        MasterController::requerirModelo("fecha");
        $item = new fecha();
        $item->postToObject();
        $item->setDate($item->getAnio()."-".$item->getMes()."-01");

        $this->transaction->loadClass($item);

        if ($this->transaction->save()) {
            $this->done = true;
            $this->doneMsg = "Fecha de ingreso Agregado con exito";
            $this->loadContentView("viewAgregar");
            return true;
        }
    }

 

    function viewDetails() {
        $this->loadContentView("viewDetails");
    }

    function viewUpdateForm() {
        $this->loadContentView("updaterForm");
    }

    function update() {
        //echo "<pre>"; print_r($_POST); echo "<pre>";


        if (!$_POST) {
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("viewAgregar");
            return false;
        }

        if (!$_POST['anio'] || !$_POST['mes']) {
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Todos los campos son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }



        MasterController::requerirModelo("fecha");
        $item = new fecha();
        $item->postToObject();
        $item->setDate($item->getAnio()."-".$item->getMes()."-01");
        //die($item->getDate());
        $this->transaction->loadClass($item);

        //echo $this->transaction->update();
        if ($this->transaction->update()) {
            $this->done = true;
            $this->doneMsg = "Fecha de ingreso editada con exito";
            $this->loadContentView("default");
            return true;
        } else {
            $this->loadContentView("default");
            return false;
        }
    }

    function delete() {
        $id = $_GET['itemId'];
        MasterController::requerirModelo("fecha");
        $item = new fecha();
        $item->setFechaId( $id );
        $this->transaction->loadClass($item);
        if ($this->transaction->delete()) {
            $this->done = true;
            $this->doneMsg = "Fecha eliminada con exito";
            $this->loadContentView("default");
            return true;
        } else {
            $this->error = true;
            $this->doneMsg = "Error al eliminar fecha";
            $this->loadContentView("default");
            return false;
        }
    }
    
    function block() {
        $id = $_GET['itemId'];
        MasterController::requerirModelo("fecha");
        $item = new fecha();
        $item->setFechaId($id);
        $item->getValuesBySetedId();
        $item->setEstado("0");
        $this->transaction->loadClass($item);
        
        if ($this->transaction->update()) {
            $this->done = true;
            $this->doneMsg = "Fecha de ingreso bloqueada";
            $this->loadContentView("default");
            return true;
        } else {
            $this->loadContentView("default");
            return false;
        }
        
    }
    
    
    function unblock() {
        $id = $_GET['itemId'];
        MasterController::requerirModelo("fecha");
        $item = new fecha();
        $item->setFechaId($id);
        $item->getValuesBySetedId();
        $item->setEstado("1");
        $this->transaction->loadClass($item);
        
        if ($this->transaction->update()) {
            $this->done = true;
            $this->doneMsg = "Fecha de ingreso activada";
            $this->loadContentView("default");
            return true;
        } else {
            $this->loadContentView("default");
            return false;
        }
        
    }
    
    

}

?>
