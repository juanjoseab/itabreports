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
class modulesController extends Display {

    var $grid;
    var $rowsCount;

    function deploy() {
        $this->params = array();
        $this->vista = "modules";
        if ($this->acl->haveAccess()) {
            if (!empty($_GET['action'])) {
                $action = $_GET['action'];
                if (method_exists($this, $action)) {
                    $this->$action();
                }
            } else {
                $this->listModules();
            }
        } else {
            $this->loadContentView("nopermision");
        }
        require_once P_THEME . DS . "index.php";
    }

    function viewAdd() {
        $this->loadContentView("createform");
    }

    function viewModuleEditionForm() {
        $this->loadContentView("editform");
    }

    function createModule() {
        MasterController::requerirModelo("module");
        $module = new module();
        $module->postToObject();

        if ($module->getIdParent() == "PARENT") {
            $module->setIdParent(Null);
        }
        if ($_POST['visible'] == "NO") {
            $module->setVisible("000");
        } else {
            $module->setVisible(1);
        }
        $this->transaction->loadClass($module);
        $this->transaction->save();
        $this->listModules();
    }

    function editModule() {
        MasterController::requerirModelo("module");
        $module = new module();
        $module->postToObject();
        $module->getValuesBySetedId();
        //$this->_pre($_POST);

        if (isset($_POST['name']) && $_POST['name'] != $module->getName()) {
            $module->setName($_POST['name']);
        }

        if (isset($_POST['path']) && $_POST['path'] != $module->getPath()) {
            $module->setPath($_POST['path']);
        }

        
            if ($_POST['id_parent'] == "PARENT") {
                $module->setIdParent(NULL);
            } else {
                $module->setName($_POST['name']);
            }
        

        
            if ($_POST['visible'] == "NO") {
                $module->setVisible("000");
            } else {
                $module->setVisible(1);
            }
            
        


        $this->transaction->loadClass($module);
        $this->transaction->update(true);
        $this->info = true;
        $this->infoMsg = "<h4>Info</h4>Edición exitosa";
        //$this->_pre($module, true);
        $this->listModules();
    }

    function listModules() {
        $modules = $this->getModules();
        $orderModules = $this->orderModules($modules);
        $this->params['modulesTree'] = $orderModules;
        $this->loadContentView("default");
    }
    
    function deleteRequest(){        
        $this->loadContentView("deleteConfirm");
    }

    function viewModuleList() {
        $this->listModules();
    }
    
    function deleteModule(){
        MasterController::requerirModelo("module");
        $module = new module();
        $module->postToObject();
        $module->getValuesBySetedId();
        $this->transaction->loadClass($module);
        $this->transaction->delete();
        //$this->_pre($module,true);
        $this->listModules();
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

}

?>
