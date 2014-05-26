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
class departamentoController extends Display{
    var $grid;
    var $rowsCount;
    
    function deploy(){
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "departamento";
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
    
    function createDepartamentoGrid($loadGrid=true){
        MasterController::requerirClase("MysqlSelect");
        $mselect =  new MysqlSelect();
        $mselect->setTableReference("departamento");
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
    
    
    function viewAgregarDepto(){
        $this->loadContentView("viewAgregarDepartamento");
    }
    
    
    function insertDepto(){
        
        
        if(!$_POST){
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("viewAgregarDepartamento");
            return false;
        }
        
        if(!$_POST['nombre'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("viewAgregarDepartamento");
            return false;
        }
        MasterController::requerirModelo("departamento");
        $departamento = new departamento();
        if($_POST['nombre'] != ''){      
            $departamento->nombre['val']=$_POST['nombre'];
        }
        
        $departamento->estado['val']=$_POST['estado'];
        
        if($_POST['codigo'] != ''){
            $departamento->codigo['val']=$_POST['codigo'];
        }
        
        $this->transaction->loadClass($departamento);
        
        if($this->transaction->save()){
            $this->done = true;
            $this->doneMsg = "Departamento {$_POST[nombre]} Agregado con exito";
            $this->loadContentView("default");
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
            $this->loadContentView("viewAgregarDepartamento");
            return false;
        }
        
        if(!$_POST['nombre'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("viewAgregarDepartamento");
            return false;
        }
        
        
        
        MasterController::requerirModelo("departamento");
        $departamento = new departamento();
        if($_POST['departamento_id'] != ''){      
            $departamento->departamento_id['val']=$_POST['departamento_id'];
        }
        
        if($_POST['nombre'] != ''){      
            $departamento->nombre['val']=$_POST['nombre'];
        }
        
        $departamento->estado['val']=$_POST['estado'];
        $departamento->codigo['val']=$_POST['codigo'];
        
        $this->transaction->loadClass($departamento);
       
        //echo $this->transaction->update();
        if($this->transaction->update()){
            $this->done = true;
            $this->doneMsg = "Departamento {$_POST[nombre]} editado con exito";
            $this->loadContentView("updateForm");
            return true;
        }else{
            $this->loadContentView("updateForm");
            return true;
        }
        
        
    }
    
    
    function delete(){
        $id = $_GET['itemId'];
        MasterController::requerirModelo("departamento");
        $departamento = new departamento();
        $departamento->departamento_id['val']=$id;
        $this->transaction->loadClass($departamento);
        if($this->transaction->delete()){
            $this->done = true;
            $this->doneMsg = "Departamento eliminado con exito";
            $this->loadContentView("default");
            return true;
        }
        
    }
    
    
    function getDepartamentoByID(){
        $this->loadContentView("getDepartamentoById");
        $this->getContentView();
        die;
    }
    
    function addMunicipio(){
        
        if($_POST){
            MasterController::requerirModelo("municipio");
            $municipio = new municipio();
            
            //nombre=asdf&codigo=asdf&departamentoNombre=Guatemala&departamento_id=1&estado=1
            if($_POST['nombre']!=""){
                $municipio->nombre['val']=utf8_decode($_POST['nombre']);
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El nombre del Municipio no puede quedar vacio";
            }
            
            if($_POST['departamento_id']!=""){
                $municipio->departamento_id['val']=$_POST['departamento_id'];
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del id del departamento no puede quedar vacio";
            }
            
            if($_POST['estado']!=""){
                $municipio->estado['val']=$_POST['estado']; 
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del id del departamento no puede quedar vacio";
            }
            $municipio->codigo['val']=$_POST['codigo'];
            
            
            $this->transaction->loadClass($municipio);
            if($this->transaction->save()){
                $this->done = true;
                $this->doneMsg = "Municipio {$_POST[nombre]} con exito";
                //$this->loadContentView("default"); 
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Ooops!</h4>Error al ingresar el municipio {$_POST[nombre]}, intentelo de nuevo";
            }
        }else{
            $this->error = true;
            $this->errorMsg = "<h4>Datos no recibidos!</h4>Error al ingresar el municipio {$_POST[nombre]}, intentelo de nuevo";
                      
        }
        
        
        $this->loadContentView("resultadoAddMunicipio");        
        $this->getContentView();
        die;
    }
}

?>
