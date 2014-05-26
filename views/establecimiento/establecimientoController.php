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
class establecimientoController extends Display{
    var $grid;
    var $rowsCount;
    
    function deploy(){
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "establecimiento";
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
         
        
    }
    
    function createGrid(){
        MasterController::requerirClase("MysqlSelect");
        $mselect =  new MysqlSelect();
        $mselect->setTableReference("establecimiento_salud");
        //$mselect->addSelection($table, $select)
        
        $mselect->addSelection("tipo_establecimiento_salud","nombre","tipo");

        //datos del distrito de salud
        $mselect->addSelection("distrito_salud","nombre","dms_nombre");        
        
        //datos del area de salud
        $mselect->addSelection("area_salud","nombre","das_nombre");        
        
        //datos del municipio
        $mselect->addSelection("municipio","nombre","municipio_nombre");
        
        //datos del departamento
        $mselect->addSelection("departamento","nombre","departamento_nombre");
        
        $mselect->addJoin("tipo_establecimiento_salud", "tipo_establecimiento_salud_id", "=", "establecimiento_salud", "tipo_establecimiento_salud_id", "left");
        $mselect->addJoin("distrito_salud", "distrito_salud_id", "=", "establecimiento_salud", "distrito_salud_id", "left");
        $mselect->addJoin("area_salud", "area_salud_id", "=", "distrito_salud", "area_salud_id", "left");
        $mselect->addJoin("municipio", "municipio_id", "=", "distrito_salud", "municipio_id", "left");
        $mselect->addJoin("departamento", "departamento_id", "=", "municipio", "departamento_id");
        if($_GET['filtro']==1){
            if($_POST['departamentoId']){
                $mselect->addFilter("departamento", "departamento_id", $_POST['departamentoId'], "=");
            }elseif($_GET['departamentoId']){
                $mselect->addFilter("departamento", "departamento_id", $_GET['departamentoId'], "=");
            }            
        }
        
        //$mselect->addGroup("distrito_salud", "distrito_salud_id");
        //$mselect->addFilter("departamento", "estado", "1", "=");
        if($_GET['pag']>0){
            $pag = ($_GET['pag'] * ITEMSPERPAGE);            
            $mselect->addComplexLimit($pag, ITEMSPERPAGE);
        }else{
            $mselect->addSimpleLimit(ITEMSPERPAGE);
        }
        
        $mselect->addOrderBy("distrito_salud", "distrito_salud_id", "ASC");
        
        if($mselect->execute()){
            $this->grid = $mselect->rows;
            if($loadGrid){
                $this->loadContentView("grid");   
            }            
        }
        
        $this->rowsCount = $mselect->rowsCount();
        
    }
    
    
    function createTiposGrid(){
        MasterController::requerirClase("MysqlSelect");
        $mselect =  new MysqlSelect();
        $mselect->setTableReference("tipo_establecimiento_salud");
        if($_GET['pag']>0){
            $pag = ($_GET['pag'] * ITEMSPERPAGE);            
            $mselect->addComplexLimit($pag, ITEMSPERPAGE);
        }else{
            $mselect->addSimpleLimit(ITEMSPERPAGE);
        }
        
        
        
        if($mselect->execute()){
            $this->grid = $mselect->rows;            
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
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        if(!$_POST['area_salud_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de area de salud es obligatorio";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        
        
        
        if(!$_POST['municipio_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de municipio es obligatorio";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        
        
        
        MasterController::requerirModelo("distrito_salud");
        $item = new distrito_salud();
        if($_POST['nombre'] != ''){      
            $item->nombre['val']=$_POST['nombre'];
        }
        
        if($_POST['area_salud_id']){
            $item->area_salud_id['val'] =$_POST['area_salud_id'];
        }
        
                
        if($_POST['municipio_id']){
            $item->municipio_id['val'] =$_POST['municipio_id'];
        }
        
        
        
        $item->estado['val']=$_POST['estado'];
        
        

        $this->transaction->loadClass($item);
        
        if($this->transaction->save()){
            $this->done = true;
            $this->doneMsg = "Distrito de salud {$_POST[nombre]} agregado con exito";
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
            $this->loadContentView("updateForm");
            return false;
        }
        
        if(!$_POST['distrito_salud_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("updateForm");
            return false;
        }
        
        if(!$_POST['nombre'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estado son obligatorios";
            $this->loadContentView("updateForm");
            return false;
        }
        
        if(!$_POST['area_salud_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de area de salud es obligatorio";
            $this->loadContentView("updateForm");
            return false;
        }
        
        if(!$_POST['municipio_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de municipio es obligatorio";
            $this->loadContentView("updateForm");
            return false;
        }
        
        
        
        
        MasterController::requerirModelo("distrito_salud");
        $item = new distrito_salud();
        if($_POST['distrito_salud_id'] != ''){      
            $item->distrito_salud_id['val']=$_POST['distrito_salud_id'];
        }
        
        if($_POST['nombre'] != ''){      
            $item->nombre['val']=$_POST['nombre'];
        }
        
        if($_POST['area_salud_id']){
            $item->area_salud_id['val'] =$_POST['area_salud_id'];
        }
        
                
        if($_POST['municipio_id']){
            $item->municipio_id['val'] =$_POST['municipio_id'];
        }
        
        
        
        $item->estado['val']=$_POST['estado'];
        
        

        $this->transaction->loadClass($item);
        
        //echo "<pre>"; print_r($item); echo "<pre>";
        
        if($this->transaction->update()){
            $this->done = true;
            $this->doneMsg = "Distrito de salud {$_POST[nombre]} modificado con exito";
            $this->loadContentView("default");
            return true;
        }
        
        
    }
    
    
    function delete(){
        $id = $_GET['itemId'];
        MasterController::requerirModelo("distrito_salud");
        $item = new distrito_salud();
        $item->distrito_salud_id['val']=$id;
        $this->transaction->loadClass($item);
        if($this->transaction->delete()){
            $this->done = true;
            $this->doneMsg = "Distrito de salud eliminado con exito";
            $this->loadContentView("default");
            return true;
        }else{
            $this->error = true;
            $this->doneMsg = "Error al eliminar municipio";
            $this->loadContentView("default");
            return false;
        }
        
    }
    
    
    
    
    function addTipoEstablecimiento(){
        
        if($_POST){
            MasterController::requerirModelo("tipo_establecimiento_salud");
            $item = new tipo_establecimiento_salud();
            
            //nombre=asdf&codigo=asdf&departamentoNombre=Guatemala&departamento_id=1&estado=1
            if($_POST['nombre']!=""){
                $item->nombre['val']=utf8_decode($_POST['nombre']);
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El nombre del Lugar poblado no puede quedar vacio";
            }
            
            $this->transaction->loadClass($item);
            if($this->transaction->save()){
                $this->done = true;
                $this->doneMsg = "Tipo establecimiento {$_POST[nombre]} guardado con exito";
                //$this->loadContentView("default"); 
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Ooops!</h4>Error al ingresar {$_POST[nombre]}, intentelo de nuevo";
            }
        }else{
            $this->error = true;
            $this->errorMsg = "<h4>Datos no recibidos!</h4>Error al ingresar {$_POST[nombre]}, intentelo de nuevo";
                      
        }
        
        
        $this->loadContentView("resultadoAdd");        
        $this->getContentView();
        die;
    }
    
    
    
    function viewTipos(){
        $this->loadContentView("tipos");
        
    }
    
    function viewTiposUpdateForm(){
        $this->loadContentView("tiposUpdateForm");
    }
    
    function updateTipo(){
        if($_POST){
            MasterController::requerirModelo("tipo_establecimiento_salud");
            $item = new tipo_establecimiento_salud();
            $item->tipo_establecimiento_salud_id['val'] = $_POST['tipo_establecimiento_salud_id'];
            //nombre=asdf&codigo=asdf&departamentoNombre=Guatemala&departamento_id=1&estado=1
            if($_POST['nombre']!=""){
                $item->nombre['val']=utf8_decode($_POST['nombre']);
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Datos incompleto!</h4>El nombre del Lugar poblado no puede quedar vacio";
            }
            
            $this->transaction->loadClass($item);
            if($this->transaction->update()){
                $this->done = true;
                $this->doneMsg = "Tipo establecimiento {$_POST[nombre]} guardado con exito";
                //$this->loadContentView("default"); 
            }else{
                $this->error = true;
                $this->errorMsg = "<h4>Ooops!</h4>Error al ingresar {$_POST[nombre]}, intentelo de nuevo";
            }
        }else{
            $this->error = true;
            $this->errorMsg = "<h4>Datos no recibidos!</h4>Error al ingresar {$_POST[nombre]}, intentelo de nuevo";
                      
        }
        $this->loadContentView("tipos");
    }
    
    function deleteTipo(){
        $id = $_GET['itemId'];
        MasterController::requerirModelo("tipo_establecimiento_salud");
        $item = new tipo_establecimiento_salud();
        $item->tipo_establecimiento_salud_id['val']=$id;
        $this->transaction->loadClass($item);
        if($this->transaction->delete()){
            $this->done = true;
            $this->doneMsg = "Tipo de establecimiento eliminado con exito";
            
        }else{
            $this->error = true;
            $this->doneMsg = "Error al eliminar tipo de establecimiento";
            
        }
        
        $this->loadContentView("tipos");
    }
    
}

?>
