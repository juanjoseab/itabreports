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
class municipioController extends Display{
    var $grid;
    var $rowsCount;
    
    function deploy(){
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "municipio";
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
        $mselect->setTableReference("municipio");
        //$mselect->addSelection($table, $select)
        $mselect->addCustomSelection("municipio.*, departamento.nombre as departamento_nombre ");
        $mselect->addJoin("departamento", "departamento_id", "=", "municipio", "departamento_id", "left");
        if($_GET['filtro']==1){
            if($_POST['departamentoId']){
                $mselect->addFilter("departamento", "departamento_id", $_POST['departamentoId'], "=");
            }elseif($_GET['departamentoId']){
                $mselect->addFilter("departamento", "departamento_id", $_GET['departamentoId'], "=");
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
                if($initpage+6 < $totalpags){
                    $topage = $initpage+6;
                }else{
                    $topage = $initpage + (($totalpags - $initpage) - 1);
                }
                for($i=$initpage;$i<=$topage;$i++){
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
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        if(!$_POST['departamento_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de departamento es obligatorio";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        MasterController::requerirModelo("municipio");
        $municipio = new municipio();
        if($_POST['nombre'] != ''){      
            $municipio->nombre['val']=$_POST['nombre'];
        }
        
        if($_POST['departamento_id']){
            $municipio->departamento_id['val'] =$_POST['departamento_id'];
        }
        
        $municipio->estado['val']=$_POST['estado'];
        
        if($_POST['codigo'] != ''){
            $municipio->codigo['val']=$_POST['codigo'];
        }

        $this->transaction->loadClass($municipio);
        
        if($this->transaction->save()){
            $this->done = true;
            $this->doneMsg = "Municipio {$_POST[nombre]} Agregado con exito";
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
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        
        
        MasterController::requerirModelo("municipio");
        $municipio = new municipio();
        if($_POST['municipio_id'] != ''){      
            $municipio->municipio_id['val']=$_POST['municipio_id'];
        }
        
        if($_POST['nombre'] != ''){      
            $municipio->nombre['val']=$_POST['nombre'];
        }
        
        if($_POST['departamento_id'] != ''){      
            $municipio->departamento_id['val']=$_POST['departamento_id'];
        }
        
        $municipio->estado['val']=$_POST['estado'];
        $municipio->codigo['val']=$_POST['codigo'];
        
        $this->transaction->loadClass($municipio);
       
        //echo $this->transaction->update();
        if($this->transaction->update()){
            $this->done = true;
            $this->doneMsg = "Municipio {$_POST[nombre]} editado con exito";
            $this->loadContentView("default");
            return true;
        }else{
            $this->loadContentView("defautl");
            return false;
        }
        
        
    }
    
    
    function delete(){
        $id = $_GET['itemId'];
        MasterController::requerirModelo("municipio");
        $municipio = new municipio();
        $municipio->municipio_id['val']=$id;
        $this->transaction->loadClass($municipio);
        if($this->transaction->delete()){
            $this->done = true;
            $this->doneMsg = "Municipio eliminado con exito";
            $this->loadContentView("default");
            return true;
        }else{
            $this->error = true;
            $this->doneMsg = "Error al eliminar municipio";
            $this->loadContentView("default");
            return false;
        }
        
    }
    
    
    
    
    function addLugarPoblado(){
        
        if($_POST){
            MasterController::requerirModelo("lugar_poblado");
            $item = new lugar_poblado();
            
            //nombre=asdf&codigo=asdf&departamentoNombre=Guatemala&departamento_id=1&estado=1
            if($_POST['nombre']!=""){
                $item->nombre['val']=utf8_decode($_POST['nombre']);
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El nombre del Lugar poblado no puede quedar vacio";
            }
            
            if($_POST['municipio_id']!=""){
                $item->municipio_id['val']=$_POST['municipio_id'];
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del id del municipio no puede quedar vacio";
            }
            
            if($_POST['estado']!=""){
                $item->estado['val']=$_POST['estado']; 
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El campo del estado no puede quedar vacio";
            }
            $item->codigo['val']=$_POST['codigo'];
            
            
            $this->transaction->loadClass($item);
            if($this->transaction->save()){
                $this->done = true;
                $this->doneMsg = "Lugar Poblado {$_POST[nombre]} con exito";
                //$this->loadContentView("default"); 
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Ooops!</h4>Error al ingresar el lugar poblado {$_POST[nombre]}, intentelo de nuevo";
            }
        }else{
            $this->error = true;
            $this->errorMsg = "<h4>Datos no recibidos!</h4>Error al ingresar el lugar poblado {$_POST[nombre]}, intentelo de nuevo";
                      
        }
        
        
        $this->loadContentView("resultadoAddLP");        
        $this->getContentView();
        die;
    }
}

?>
