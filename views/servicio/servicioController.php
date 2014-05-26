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
class servicioController extends Display{
    var $grid;
    var $rowsCount;
    
    function deploy(){
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "servicio";
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
        $mselect->setTableReference("servicio_intrahospitalario");
        $mselect->addCustomSelection("servicio_intrahospitalario.*");
        $mselect->addSelection("estandar", "nombre","estandar_nombre");
        $mselect->addJoin("estandar", "estandar_id", "=", "servicio_intrahospitalario", "estandar_id", "LEFT");
        //$mselect->addSelection($table, $select)
        //$mselect->addCustomSelection("municipio.*, departamento.nombre as departamento_nombre ");
        //$mselect->addJoin("departamento", "departamento_id", "=", "municipio", "departamento_id", "left");
        if($_GET['filtro']==1){
            if($_POST['estandarId']){
                $mselect->addFilter("estandar", "estandar_id", $_POST['estandarId'], "=");
            }elseif($_GET['estandarId']){
                $mselect->addFilter("estandar", "estandar_id", $_GET['estandarId'], "=");
            }            
        }
        
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
            $this->errorMsg = "<h4>Campos incompletos!</h4> Los datos de nombre, estandar y estado son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        MasterController::requerirModelo("servicio_intrahospitalario");
        $item = new servicio_intrahospitalario();
        if($_POST['nombre'] != ''){      
            $item->nombre['val']=$_POST['nombre'];
        }
        
        
        if($_POST['estandar_id'] != ''){      
            $item->estandar_id['val']=$_POST['estandar_id'];
        }
        

        $this->transaction->loadClass($item);
        
        if($this->transaction->save()){
            $this->done = true;
            $this->doneMsg = "Servicio intrahospitalario {$_POST[nombre]} Agregado con exito";
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
            $this->loadContentView("default");
            return false;
        }
        
        if(!$_POST['nombre'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estandar son obligatorios";
            $this->loadContentView("default");
            return false;
        }
        
        if(!$_POST['estandar_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estandar son obligatorios";
            $this->loadContentView("default");
            return false;
        }
        
        
        MasterController::requerirModelo("indicador");
        $item = new indicador();
        if($_POST['indicador_id'] != ''){ 
            $item->indicador_id['val']=$_POST['indicador_id'];
        }
        
        if($_POST['estandar_id'] != ''){ 
            $item->estandar_id['val']=$_POST['estandar_id'];
        }
        
        if($_POST['nombre'] != ''){      
            $item->nombre['val']=$_POST['nombre'];
        }
        
        
        $item->descripcion['val']=$_POST['descripcion'];
        
        
        $this->transaction->loadClass($item);
       
        //echo $this->transaction->update();
        if($this->transaction->update()){
            $this->done = true;
            $this->doneMsg = "Indicador {$_POST[nombre]} editado con exito";
            $this->loadContentView("default");
            return true;
        }else{
            $this->loadContentView("default");
            return false;
        }
        
        
    }
    
    
    function delete(){
        if($this->acl->acl("Eliminar")){
            $id = $_GET['itemId'];
            MasterController::requerirModelo("indicador");
            $item = new indicador();
            $item->indicador_id['val']=$id;
            $this->transaction->loadClass($item);
            if($this->transaction->delete()){
                $this->done = true;
                $this->doneMsg = "Indicador eliminado con exito";
                $this->loadContentView("default");
                return true;
            }else{
                $this->error = true;
                $this->doneMsg = "Error al eliminar el Indicador";
                $this->loadContentView("default");
                return false;
            }
        }else{
            $this->error = true;
            $this->doneMsg = "No tiene permisos para eliminar";
            $this->loadContentView("default");
            return false;
        }
        
        
        
    }
    
    
    
    
    function addChild(){
        
        if($_POST){
            MasterController::requerirModelo("valor_indicador");
            $item = new valor_indicador();
            
            //nombre=asdf&codigo=asdf&departamentoNombre=Guatemala&departamento_id=1&estado=1
            if($_POST['valor']!=""){
                $item->valor['val']=utf8_decode($_POST['valor']);
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4> El valor no puede quedar vacio";
            }
            
            if($_POST['indicador_id']!=""){
                $item->indicador_id['val']=$_POST['indicador_id'];
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del indicador no puede quedar vacio";
            }
            
            
            $this->transaction->loadClass($item);
            if($this->transaction->save()){
                $this->done = true;
                $this->doneMsg = "Valor {$_POST[nombre]} agregado con exito";
                //$this->loadContentView("default"); 
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Ooops!</h4>Error en el ingreso, intentelo de nuevo";
            }
        }else{
            $this->error = true;
            $this->errorMsg = "<h4>Datos no recibidos!</h4>Error en el ingreso, intentelo de nuevo";
                      
        }
        
        
        $this->loadContentView("resultadoAddChild");        
        $this->getContentView();
        die;
    }
    
    function returnOptions(){
        $this->loadContentView("getById");
        $this->getContentView();
        die;
    }
    
}

?>
