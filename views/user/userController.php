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
class userController extends Display {

    var $grid;
    var $rowsCount;

    function deploy() {
        $this->params = array();
        $this->vista = "user";
        if ($this->acl->haveAccess()) {

            if (!empty($_GET['action'])) {
                $action = $_GET['action'];
                if (method_exists($this, $action)) {
                    $this->$action();
                }
            }
        } else {
            $this->loadContentView("nopermision");
        }
        require_once P_THEME . DS . "index.php";
    }
    
    function unblockUser(){
        $uid = $_GET["uid"];
        MasterController::requerirModelo("user");
        $user = new user();
        $user->setIdUser($uid);
        $user->getValuesBySetedId();
        $user->setStatus(1);
        $this->transaction->loadClass($user);
        $this->transaction->update();
        $this->loadContentView("default");
    }

    function blockUser() {
        $uid = $_GET["uid"];
        MasterController::requerirModelo("user");
        $user = new user();
        $user->setIdUser($uid);
        $user->getValuesBySetedId();
        $user->setStatus("0");
        $this->transaction->loadClass($user);
        $this->transaction->update();
        $this->loadContentView("default");
    }

    function viewCreate() {
        $this->loadContentView("userform");
    }

    function viewEdit() {
        $this->loadContentView("editform");
    }

    function createUser() {
        MasterController::requerirModelo("user");
        $user = new user();
        $user->postToObject();

        if ($_POST["pass"] != $_POST["repass"]) {
            $this->error = true;
            $this->errorMsg = "<h4>¡¡Error!!</h4>Las contraseñas no coinciden";
            $this->loadContentView("userform");
            return;
        }

        $user->setPass(sha1(md5($_POST["pass"])));
        $this->transaction->loadClass($user);
        $this->transaction->save();
        $this->loadContentView("default");
    }

    function editUser() {
        MasterController::requerirModelo("user");
        $user = new user();
        $user->postToObject();
        $user->getValuesBySetedId();
        //$this->_pre($user);die;

        if (isset($_POST["pass"])) {
            if ($_POST["pass"] != $_POST["repass"]) {
                $this->error = true;
                $this->errorMsg = "<h4>¡¡Error!!</h4>Las contraseñas no coinciden";
                $this->loadContentView("editform");
                return;
            } else {
                $user->setPass(sha1(md5($_POST["pass"])));
            }
        }

        if (isset($_POST['name']) && $_POST['name'] != $user->getName()) {
            $user->setName($_POST['name']);
        }

        if (isset($_POST['login']) && $_POST['login'] != $user->getLogin()) {
            $user->setLogin($_POST['login']);
        }

        if (isset($_POST['status']) && $_POST['status'] != $user->getStatus()) {
            $user->setStatus($_POST['status']);
        }


        $this->transaction->loadClass($user);
        $this->transaction->update();
        $this->info = true;
        $this->infoMsg = "<h4>Info</h4>Edición de usuario exitosa";
        $this->loadContentView("default");
    }

    function manageModules() {
        MasterController::requerirModelo("user");
        $user = new user();
        $user->setIdUser($_GET['uid']);
        $user->getValuesBySetedId();

        $modules = $this->getModules();
        $modulesAsignados = $this->getModulesAsigned();
        $moduleTree = $this->checkAsignedModules($modules, $modulesAsignados);
        $orderModules = $this->orderModules($moduleTree);
        $this->params['modulesTree'] = $orderModules;

        $this->loadContentView("managemodules");
    }

    function getModules() {
        $dbo = new Dbexec();
        $sql = "SELECT * FROM module";
        $dbo->queryExecute($sql);
        $noAsignados = array();
        if ($dbo->numeroFilas() > 0) {
            while ($r = $dbo->getArray()) {
                $noAsignados[] = $r;
            }
        }
        return $noAsignados;
    }

    private function getModulesAsigned() {
        $dbo = new Dbexec();
        $sql = "
                    SELECT * FROM module m WHERE m.id_module IN (
			SELECT module.id_module 
                        FROM module    
                        JOIN accessslist
                            ON module.id_module  = accessslist.id_module
			WHERE   
                            accessslist.id_user = {$_GET['uid']});";
        $dbo->queryExecute($sql);
        $noAsignados = array();
        if ($dbo->numeroFilas() > 0) {
            while ($r = $dbo->getArray()) {
                $asignados[] = $r;
            }
        }
        return $asignados;
    }

    private function checkAsignedModules($modules, $modulesAsignados) {
        $moduleTree = array();
        foreach ($modules AS $mod) {
            $mod['checked'] = 0;
            if (is_array($modulesAsignados)) {
                foreach ($modulesAsignados AS $amod) {
                    if ($mod['id_module'] == $amod["id_module"]) {
                        $mod['checked'] = 1;
                    }
                }
            }
            $moduleTree[] = $mod;
        }
        return $moduleTree;
    }

    private function orderModules($modules) {
        $tree = array();
        $modules2 = $modules;
        foreach ($modules AS $mod) {
            if (!$mod['id_parent']) {
                $tree[$mod['id_module']]['parent'] = $mod;
                foreach ($modules2 AS $submod) {
                    if ($submod["id_parent"] == $mod['id_module']) {
                        $tree[$mod['id_module']]["childrens"][] = $submod;
                    }
                }
            }
        }
        return $tree;
    }

    function setModules() {
        
        $sql = "DELETE FROM accessslist WHERE id_user = {$_GET['uid']};";
        $dbo = new Dbexec();
        $dbo->queryExecute($sql);
        
       MasterController::requerirModelo("accessslist");
       
        foreach($_POST AS $modId){
            $acl = new accessslist();
            $acl->setIdModule($modId);
            $acl->setIdUser($_GET['uid']);
            $this->transaction->loadClass($acl);
            $this->transaction->save(TRUE);
        }
        $this->manageModules();
        
        /*$this->_pre($_POST);
        die;*/
    }

    

    function stringToDate($date) {
        $time = strtotime($date);
        return date('Y-m-d', $time);
    }

    

}

?>
