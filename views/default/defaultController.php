<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of defaultController
 *
 * @author webmaster
 */
class defaultController extends Display {

    function deploy() {
        $this->deployMainMenu();
        $this->vista = "default";
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if (method_exists($this, $action)) {
                $this->$action();
            }
        }
        require_once P_THEME . DS . "index.php";
    }

    function login() {
        $user = $_POST['login'];
        $pass = $_POST['pass'];
        $login = $this->acl->verCredenciales($user, $pass);
        if ($login) {
//print_r($login); die;
            $this->acl->setUserAccess($login[1]);
            $this->acl->setUserSession($login[1], $login[0], 1);
        } else {
            $this->error = true;
            $this->errorMsg = "<h4>¡¡Oops!!</h4>Existe un error en las credenciales, por favor verificalos e intenta de nuevo";
        }
        $this->loadContentView("default");
    }

    function logout() {
        $this->acl->logout();
        $this->info = true;
        $this->infoMsg = "<h4>¡Sesión finalizada!</h4>Sesión finalizada con exito";
        $this->loadContentView("default");
    }

}

?>
