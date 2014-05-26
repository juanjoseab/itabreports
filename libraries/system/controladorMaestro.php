<?php
defined("_SYSEXEC") or die();
/** 
 * Controlado padre para todos lo controladores, este archivo contiene los 
 * metodos globales para todo el sistema asi como la ejecución del ACL
 * 
 * La clase MasterController contiene todos los metodos globales necesarios para
 * la ejecucion de acciones y tareas asi como el despliegue de las vistas y las 
 * llamadas para la inclusion de modelos.
 * @author Juan Jose A. Baires <jbaires@enchulatuweb.com>
 * @version 1.0
 */

class MasterController {
    
    public function __construct() {
        $this->aclConfirm();
    }
    
    
    var $formulario;
    function requerirModelo($modelo){
        if(file_exists(P_MODELOS.DS.$modelo.".php")     ){
            require_once (P_MODELOS.DS.$modelo.".php");
        }
    }
    
    function requerirControlador($controlador){
        if(file_exists(P_MODELOS.DS.$controlador.".php") && (!class_exists($controlador))     ){
            require_once P_MODELOS.DS.$controlador.".php";
        }
    }
    
    function requerirControladorDeVista($vista){
        if(file_exists(P_VISTAS.DS.$vista.DS.$vista."Controller.php") ){
            require_once P_VISTAS.DS.$vista.DS.$vista."Controller.php";
        }
    }
    
    
    function requerirClase($clase){
        if(file_exists(P_CLASES.DS.$clase.".php") && (!class_exists($clase))){
            require_once (P_CLASES.DS.$clase.".php");
        }
    }
    
    function mainMenu(){
        
        /*
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about"></a></li>
              <li><a href="#contact">Contact</a></li>/*/
    }
    
    
    function aclConfirm(){
        if(isset($_SESSION['user_session']) && $_SESSION["user_session"]=="ok"){
            return true;
        }else{
            return false;
        }
        
    }
    
    function deployContent($view,$controller,$action){
        
    }
    
    
    
    
    
    
}