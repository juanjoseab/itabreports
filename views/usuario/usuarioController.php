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
class usuarioController extends Display{
    var $grid;
    var $rowsCount;
    
    function deploy(){
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "usuario";
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
              <li class="nav-header">Gesti&oacute;n de Usuarios</li>
              <li><a href="?v=usuario">Listar usuarios</a></li>
              <li><a href="?v=usuario&action=viewAgregar">Agregar usuario</a></li>
              <li><a href="?v=usuario&action=viewRol">Roles</a></li>
              <li><a href="?v=usuario&action=viewAgregarRol">Agregar rol</a></li>

            </ul>
          </div><!--/.well -->
        </div><!--/span-->';
    }
    
    function createGrid($loadGrid=true){
        MasterController::requerirClase("MysqlSelect");
        $mselect =  new MysqlSelect();
        $mselect->setTableReference("usuario");
        $mselect->addCustomSelection("usuario.*");
        $mselect->addSelection("rol","nombre","rol");
        
        $mselect->addJoin("rol", "rol_id", "=", "usuario", "rol_id", "left");
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
    
    function createRolGrid(){
        MasterController::requerirClase("MysqlSelect");
        $mselect =  new MysqlSelect();
        $mselect->setTableReference("rol");
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
    function viewRol(){
        $this->loadContentView("viewRol");
    }
    
    function viewAgregarRol(){
        $this->loadContentView("agregarRol");
    }    
    
    function insertUser(){
        
        
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
        
        if(!$_POST['login'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de login de acceso es obligatorio";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        MasterController::requerirClase("MysqlSelect");
        $sl = new MysqlSelect();
        $sl->setTableReference("usuario");
        $sl->addFilter("usuario", "login", $_POST['login'], "=");
        $sl->execute();
        if($sl->rowsCount()>0){
            $this->error = true;
            $this->errorMsg = "<h4>Error en el formulario!</h4>El login de acceso ya existe, por favor ingrese otro";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        
        if(!$_POST['clave'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>El dato de la clave es obligatorio";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        if(!$_POST['reclave'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>debe confirmar la clave";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        
        if($_POST['reclave'] != $_POST['clave'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Error en el fomulario!</h4> Las claves no coinciden, verifiquelas por favor";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        if(!$_POST['rol_id'] ){
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>el rol asignado es obligatorio";
            $this->loadContentView("viewAgregar");
            return false;
        }
        
        MasterController::requerirModelo("usuario");
        $item = new usuario();
        if($_POST['nombre'] != ''){      
            $item->nombre['val']=$_POST['nombre'];
        }
        if($_POST['login'] != ''){      
            $item->login['val']=$_POST['login'];
        }
        
        if($_POST['clave'] != ''){      
            $item->clave['val']=md5($_POST['clave']);
        }
        
        if($_POST['rol_id'] != ''){      
            $item->rol_id['val']=$_POST['rol_id'];
        }

        $this->transaction->loadClass($item);
        
        if($this->transaction->save()){
            $this->done = true;
            $this->doneMsg = "Usuario {$_POST[nombre]} [ <strong>{$_POST[login]}</strong> ] agregado con exito";
            $this->loadContentView("viewAgregar");
            return true;
        }
        
        
    }
    
    function insertRol(){
        if($_POST){
            MasterController::requerirClase("MysqlSelect");
            $sl = new MysqlSelect();
            $sl->setTableReference("rol");
            $sl->addFilter("rol", "nombre", $_POST['nombre'], "=");
            $sl->execute();
            if($sl->rowsCount()>0){
                $this->error = true;
                $this->errorMsg = "<h4>Error!</h4>El nombre del rol ya existe, por favor ingrese otro";
                $this->loadContentView("agregarRol");
                return false;
            }
            
            
            if(!$_POST['nombre'] ){
                $this->error = true;
                $this->errorMsg = "<h4>Campos incompletos!</h4>El nombre del rol es obligatorio";
                $this->loadContentView("agregarRol");
                return false;
            }
            
            
            if(!$_POST['funciones'] && count($_POST['funciones']<1)){
                $this->error = true;
                $this->errorMsg = "<h4>Campos incompletos!</h4>El rol debe tener asignadas funciones, por favor asignelas";
                $this->loadContentView("agregarRol");
                return false;
            }
            
            
            
            MasterController::requerirModelo("rol");
            MasterController::requerirModelo("permiso");
            $rol = new rol();
            $rol->nombre['val'] = $_POST['nombre'];
            $this->transaction->loadClass($rol);            
            if($this->transaction->save()){                
                
                foreach($_POST['funciones'] as $f){
                    $errF = false;
                    $permiso = new permiso();
                    $permiso->funcion_id['val'] = $f;
                    $permiso->rol_id['val'] = $rol->rol_id;
                    $this->transaction->loadClass($permiso);
                    if(!$this->transaction->saveWithNoPK()){
                        $errF .= $f .", ";                    
                    }
                    
                }
                //die;
                if($errF){
                    $errF = substr($errF, 0, -2);
                    $this->error = true;
                    $this->errorMsg = "<h4>Oops!</h4>Rol agregado, fallo la asingaci&oacute;n de las funciones $errF";
                    $this->loadContentView("agregarRol");
                    return false;
                }else{
                    $this->done = true;
                    $this->doneMsg = "Rol agregado y permisos asignados con exito";
                    $this->loadContentView("viewRol");
                    return true;
                }
            }
               /*foreach($_POST['funciones'] as $f){
                   echo " - $f";
                } 
            die;*/
            
            
            
            
        }else{
            
        }
        
        
        //echo "<pre>"; print_r($_POST); echo "</pre>";
        /*foreach ($_POST['funciones'] as $f){
            echo " - " . $f . "<br />";
        }*/
        //die;
    }
    
    
    function viewUpdateForm(){
        $this->loadContentView("updateForm");
    }
    
    function verifyLogin(){
        if($_POST && $_POST['login']){
            MasterController::requerirClase("MysqlSelect");
            $sl = new MysqlSelect();
            $sl->setTableReference("usuario");
            $sl->addFilter("usuario", "login", $_POST['login'], "=");
            $sl->execute();
            if($sl->rowsCount()>0){
                echo "1";
            }else{
                echo "2";
            }
            die;
            
        }
    }
    
    function updateUser(){
        //echo "<pre>"; print_r($_POST); echo "<pre>";
        $updateFlag = false;
        
        if(!$_POST){
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("updateForm");
            return false;
        }
        
        
        MasterController::requerirModelo("usuario");
        $item = new usuario();
        $item->usuario_id['val'] = $_POST['usuario_id'];    
        $tx = new ClassTransaction();
        $tx->loadClass($item);
        $values = $tx->returnObjectValues();
        $item->nombre['val'] = $values['nombre']; 
        $item->login['val'] = $values['login'];
        $item->clave['val'] = $values['clave'];
        $item->rol_id['val'] = $values['rol_id'];
        
        if($_POST['nombre'] != $item->nombre['val'] ) {
            $updateFlag = true; 
            $item->nombre['val'] = $_POST['nombre'];
        }
        if($_POST['clave'] && md5($_POST['clave']) != $item->clave['val'] ) {
            if(!$_POST['reclave'] ){
                $this->error = true;
                $this->errorMsg = "<h4>Campos incompletos!</h4>debe confirmar la clave";
                $this->loadContentView("viewAgregar");
                return false;
            }
            if($_POST['reclave'] != $_POST['clave'] ){
                $this->error = true;
                $this->errorMsg = "<h4>Error en el fomulario!</h4> Las claves no coinciden, verifiquelas por favor";
                $this->loadContentView("updateForm");
                return false;
            }
            $updateFlag = true;
            $item->clave['val']=md5($_POST['clave']);
        }
        
        if($_POST['rol_id'] && $_POST['rol_id'] != $item->rol_id['val'] ) {$updateFlag = true; $item->rol_id['val'] = $_POST['rol_id'];}
        
        //echo "<pre>"; print_r($_POST); echo "</pre>"; echo "<pre>"; var_dump($item); echo "</pre>"; die;
        
        
        if($updateFlag){
            $this->transaction->loadClass($item);        
            if($this->transaction->update()){
                $this->done = true;
                $this->doneMsg = "Usuario {$_POST[login]} modificado con exito";
                $this->loadContentView("default");
                return true;
            }
        }
            
        
        
    }
    
    
    function deleteUser(){
        $id = $_GET['itemId'];
        MasterController::requerirModelo("usuario");
        $item = new usuario();
        $item->usuario_id['val']=$id;
        $this->transaction->loadClass($item);
        if($this->transaction->delete()){
            $this->done = true;
            $this->doneMsg = "Usuario eliminado con exito";
            $this->loadContentView("default");
            return true;
        }else{
            $this->error = true;
            $this->doneMsg = "Error al eliminar usuario";
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
