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
class hospitalController extends Display{
    var $grid;
    var $rowsCount;
    
    function deploy(){
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "hospital";
        if(!empty ($_GET['action'])){            
            $action = $_GET['action'];
            if(method_exists($this,$action)){
                $this->$action();
            }
        }
        
        
        require_once P_THEME.DS."index.php";
    }
    
    
    function deploySideMenu(){
        $this->sideMenu = "";
         
        $this->sideMenu .= '<div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Hospitales</li>
              <li><a href="?v=hospital">Listar Hospitales</a></li>
              <li><a href="?v=hospital&action=viewAgregar">Agregar Hospital</a></li>
              
              <li class="nav-header">Servicios Intra-Hospitalario</li>
              <li><a href="?v=servicio">Listar Servicios</a></li>
              <li><a href="?v=servicio&action=viewAgregar">Agregar Servicio</a></li>
              
              <li class="nav-header">Geografia</li>
              <li><a href="?v=departamento">Listar Departamentos</a></li>
              <li><a href="?v=departamento&action=viewAgregarDepto">Agregar Departamento</a></li>
              <li><a href="?v=municipio">Listar Municipios</a></li>
              <li><a href="?v=municipio&action=viewAgregar">Agregar Municipio</a></li>
              
            </ul>
          </div><!--/.well -->
        </div><!--/span-->';
    }
    
    function createGrid($loadGrid=true){
        MasterController::requerirClase("MysqlSelect");
        $mselect =  new MysqlSelect();
        $mselect->setTableReference("hospital");
        //$mselect->addSelection($table, $select)
        //$mselect->addCustomSelection("municipio.*, departamento.nombre as departamento_nombre ");
        //$mselect->addJoin("departamento", "departamento_id", "=", "municipio", "departamento_id", "left");
        
        
        //$mselect->addFilter("departamento", "estado", "1", "=");
        if($_GET['pag']>0){
            $pag = ($_GET['pag'] * ITEMSPERPAGE);            
            $mselect->addComplexLimit($pag, ITEMSPERPAGE);
        }else{
            $mselect->addSimpleLimit(ITEMSPERPAGE);
        }
        
        if($mselect->execute()){
            $this->grid = $mselect->rows;
            if($loadGrid){
                $this->loadContentView("grid");   
            }            
        }
        
        $this->rowsCount = $mselect->rowsCount();
        
    }
    
    
    function getPaginacionPosition(){
        return ceil($this->rowsCount/ITEMSPERPAGE);
    }
    
    function getArrayPaginacion(){
        $totalpags =$this->getPaginacionPosition();
        if($totalpags<7){
            $pags = Array();
            for($i=0;$i<$totalpags;$i++){
                $pags[]=$i;
            }
            return $pags;
        }else{
            if($_GET['pag']>3){
                $initpage=$_GET['pag']-3;
                for($i=$initpage;$i<=($initpage+1);$i++){
                    $pags[]=$i;
                }
            }else{
                $pags = Array();
                for($i=0;$i<7;$i++){
                    $pags[]=$i;
                }
            }
            return $pags;
            
        }
        
    }
    
    
    function viewAgregar(){
        $this->loadContentView("viewAgregar");
    }
    
    
    function insert(){
        
        
        if(!$_POST){
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        if(!$_POST['nombre'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4> El nombre es obligatorio";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        MasterController::requerirModelo("hospital");
        $item = new hospital();
        
        $item->postToObject();
        
        $this->transaction->loadClass($item);
        
        if($this->transaction->save()){
            $this->done = true;
            $this->doneMsg = "Hospital {$_POST[nombre]} Agregado con exito";
            $this->loadContentView("viewAgregar");
            return true;
        }
        
        
    }
    
    function viewUpdateForm(){
        $this->loadContentView("updateForm");
    }
    
    function update(){
        //echo "<pre>"; print_r($_POST); echo "<pre>";
        
        
        if(!$_POST){
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        if(!$_POST['nombre'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Todos los campos son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        if(!$_POST['municipio_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Todos los campos son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        
        
        MasterController::requerirModelo("hospital");
        $item = new hospital();
        $item->postToObject();
        
        $this->transaction->loadClass($item);
       
        //echo $this->transaction->update();
        if($this->transaction->update()){
            $this->done = true;
            $this->doneMsg = "Hospital {$_POST[nombre]} editado con exito";
            $this->loadContentView("default");
            return true;
        }else{
            $this->loadContentView("default");
            return false;
        }
        
        
    }
    
    
    function delete(){
        $id = $_GET['itemId'];
        MasterController::requerirModelo("hospital");
        $item = new hospital();
        $item->hospital_id['val']=$id;
        $this->transaction->loadClass($item);
        if($this->transaction->delete()){
            $this->done = true;
            $this->doneMsg = "Hospita eliminado con exito";
            $this->loadContentView("default");
            return true;
        }else{
            $this->error = true;
            $this->doneMsg = "Error al eliminar el Hospital";
            $this->loadContentView("default");
            return false;
        }
        
    }
    
    
   
    
    function returnOptions(){
        $this->loadContentView("getById");
        $this->getContentView();
        die;
    }
    
    
    function getDeptos($format = null){
        MasterController::requerirModelo('departamento');
        $deptos = new departamento();
        $list = $deptos->getList();
        if($format == 'json'){
            return json_encode($list);
        }else{
            return $list;
        }
        
    }
    
    function getMunicipios($id = false,$die = true){
        if($id){
            $did = $id;
        }else{
            $did = $_GET['did'];
        }        
        MasterController::requerirModelo('municipio');
        $mun = new municipio();
        $list = $mun->getList(array('municipio_id','nombre'),array('departamento_id'=>array($did,"=")));
        if($die){
            echo json_encode($list);die;
        }else{
            return $list;
        }
        
    }
    
}

?>
