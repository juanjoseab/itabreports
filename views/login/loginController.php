
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginController
 *
 * @author webmaster
 */
class loginController extends Display{
    
    var $error = false;
    var $good = false;
    function deploy(){
        $this->vista = "login";
        $sesionOk = ControlSesiones::sessionActive();
        
        if(!empty ($_GET['action'])){            
            $action = $_GET['action'];
            if(method_exists($this,$action)){
                $this->$action();
            }
        }
            
        if($sesionOk){
            $this->deployMainMenu();
            $this->vista = "default";
            
        }
        
        
        
        
        require_once P_THEME.DS."index.php";
    }
    
    function register(){
        
        $credencialesOk = ControlSesiones::verCredenciales($_POST['usuario'],$_POST['passwd']);
        if($credencialesOk){
            $this->systemRedirect("index.php?v=default");
            //$this->vista = "default";
            
        }else{
            $this->error = true;
        }
        
    }
    
    function logout(){
        $sesControl = new ControlSesiones();
        if($sesControl->logOut()){
            $this->vista = "login";
            $this->systemRedirect("index.php");
        }
        
        
        
        
    }
    
    
    function deploySideMenu(){
        /*
         * <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Sidebar</li>
              <li class="active"><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
*/
    
    }
    
}

?>
