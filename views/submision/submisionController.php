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
class submisionController extends Display{
    var $grid;
    var $rowsCount;
    
    function deploy(){
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "submision";
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
    
    function createGrid($loadGrid=true){
        MasterController::requerirClase("MysqlSelect");
        $mselect =  new MysqlSelect();
        $mselect->setTableReference("indicador");
        $mselect->addCustomSelection("indicador.*");
        $mselect->addSelection("estandar", "nombre","estandar_nombre");
        $mselect->addJoin("estandar", "estandar_id", "=", "indicador", "estandar_id", "LEFT");
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
        
        MasterController::requerirModelo("indicador");
        $item = new indicador();
        if($_POST['nombre'] != ''){      
            $item->nombre['val']=$_POST['nombre'];
        }
        
        
        
        if($_POST['estandar_id'] != ''){      
            $item->estandar_id['val']=$_POST['estandar_id'];
        }
        
        
        $item->descripcion['val']=$_POST['descripcion'];

        $this->transaction->loadClass($item);
        
        if($this->transaction->save()){
            $this->done = true;
            $this->doneMsg = "indicador {$_POST[nombre]} Agregado con exito";
            $this->loadContentView("viewAgregar");
            return true;
        }
        
        
    }
    
    
    function doSubmission(){
        if(!$_POST){
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";                        
            $this->loadContentView("submision");
            $this->getContentView();
            die;
        }else{
            MasterController::requerirModelo("submision");
            $item = new submision();
        }
        
        if(!$_POST['nombre_personal'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato del nombre del personal es obligatorio";
            $this->loadContentView("submision");
            $this->getContentView();
            die;
        }else{
            $item->nombre_personal['val']=$_POST['nombre_personal'];
        }
        if(!$_POST['historia_clinica'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de historia clinica es obligatorio";
            $this->loadContentView("submision");
            $this->getContentView();
            die;
        }else{
            $item->nombre_personal['val']=$_POST['historia_clinica'];
        }
  
        
        if(!$_POST['date'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4> El dato de fecha es obligatorio";
            $this->loadContentView("submision");
            $this->getContentView();
            die;
        }else{
            $item->setFechaId($_POST['date']);
        }
        
        if(!$_POST['estandar_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato del estandar es obligatorio";
            $this->loadContentView("submision");
            $this->getContentView();
            die;
        }else{
            $item->estandar_id['val']=$_POST['estandar_id'];
        }
        
        if(!$_POST['hospital_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato del nombre del Hospital es obligatorio";
            $this->loadContentView("submision");
            $this->getContentView();
            die;
        }else{
            $item->hospital_id['val']=$_POST['hospital_id'];
        }
        
        if(!$_POST['servicio_intrahospitalario_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato del nombre del servicio intrahospitalario es obligatorio";
            $this->loadContentView("submision");
            $this->getContentView();
            die;
        }else{
            $item->servicio_intrahospitalario_id['val']=$_POST['servicio_intrahospitalario_id'];
        }

        
        //$item->fecha['val'] = date("Y-m-d");
        $item->cargo['val'] = $_POST['cargo'];
        $item->historia_clinica['val'] = $_POST['historia_clinica'];

        
        //$this->grid = $item;
        
        
        //echo "<pre>"; print_r($_POST);echo "<pre>";
        $hexIds = explode("578460921",$_POST['indres']);
        $errFlag = false;
        foreach ($hexIds AS $id){
            $itemToInsert = $item;
            $id = hexdec($id);
            $field = "indicador".$id;
            $itemToInsert->valor_indicador_id['val'] = $_POST[$field];
            $itemToInsert->fecha['val'] = date("Y-m-d H:i:s");
            $this->transaction->loadClass($itemToInsert);
            if($this->transaction->save()){
                
            }else{
                $errFlag = true;
            }            
        }
        
        if($errFlag){
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> Error al ingresar los datos";
        }else{
            $this->done = true;
            $this->doneMsg = "Dato ingresados con exito";
        }
        
        
        $this->loadContentView("submision");
        $this->getContentView();
        die;
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
        $this->loadContentView("getReferencias");
        $this->getContentView();
        die;
    }
    
    
    
}

?>
