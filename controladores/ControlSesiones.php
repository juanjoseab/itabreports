<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlSesiones
 *
 * @author webmaster
 */
class ControlSesiones {

    function verCredenciales($user, $pass) {
        $pass = sha1(md5($pass));
        $dbo = new Dbexec();
        $sql = "
            SELECT  user.login,
                    user.id_user
            FROM 
                user
            WHERE 
            user.login = '{$user}' AND user.pass = '$pass' AND status = 1;";

        //echo $sql; die;
        $dbo->queryExecute($sql);
        if ($dbo->numeroFilas() > 0) {
            return $dbo->getFila();
        } else {
            return false;
        }
    }

    function setUserSession($userId, $login, $sessionTtl = 1) {
        $_SESSION['user_session'] = "ok";
        $_SESSION['UID'] = $userId;
        $_SESSION['user_nombre'] = $login;
        $_SESSION['user_session_ttl'] = mktime(date('H') + 1, date('i'), date('s'), date('n'), date('j'), date('Y'));
    }

    function setUserAccess($userId) {
        $dbo = new Dbexec();
        $sql = "
            SELECT  
                module.id_module,
                module.name AS module_name,
                module.path
            FROM 
                module
            JOIN
                accessslist
                ON module.id_module = accessslist.id_module
            WHERE 
            accessslist.id_user = {$userId} AND module.id_parent IS NULL";
        $dbo->queryExecute($sql);
        if ($dbo->numeroFilas() > 0) {
            $permisos = array();
            while ($r = $dbo->getArray()) {
                $permisos[] = $r;
            }

            //Display::_pre($permisos);
            $_SESSION['user_permisions'] = $permisos;
        }
    }

    function haveAccess() {
        if (isset($_GET['v']) && !empty($_GET['v'])) {
            $viewPath = "v=" . $_GET['v'];
        }
        if (isset($_GET['action']) && !empty($_GET['action'])) {
            $actionPath = "action=" . $_GET['action'];
        }
        if (self::sessionActive()) {
            if ($_SESSION['user_permisions'] && is_array($_SESSION['user_permisions'])) {
                foreach ($_SESSION['user_permisions'] AS $module) {
                    if ($viewPath == $module["path"]) {
                        if ($actionPath) {
                            return self::verifyActionAccess($module["id_module"], $actionPath);
                        } else {
                            return true;
                        }
                    }
                }
                
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function verifyActionAccess($moduleId, $viewPath) {
        MasterController::requerirClase("MysqlSelect");
        $sl = new MysqlSelect();
        $sl->setTableReference("module");
        $sl->addSelection("module","id_module");
        $sl->addJoin("accessslist", "id_module", "=", "module", "id_module", "LEFT");
        $sl->addFilter("accessslist", "id_user", $_SESSION['UID'], "=");
        $sl->addFilter("module", "id_parent", $moduleId, "=");
        $sl->addFilter("module", "path", $viewPath, "=");
        $sl->execute();
        //Display::_pre($sl->query);
        if($sl->rowsCount()>0){
            return true;
        }else{
            return false;
        }

        MasterController::requerirClase("module");
        $model = new module();
        $filter = array("id_parent" => array($moduleId, "="), "path" => array($viewPath, "="));
        $moduleList = $model->getList(Array(), $filter);
        $sideMenu = array();
        if (is_array($moduleList) && count($moduleList) > 0) {
            return true;
        } else {
            return false;
        }


        //$this->_pre($moduleList);
    }

    function sessionTtl() {
        $now = mktime(date('H'), date('i'), date('s'), date('n'), date('j'), date('Y'));
        if (isset($_SESSION['user_session_ttl']) && $_SESSION['user_session_ttl'] > $now) {
            $_SESSION['user_session_ttl'] = mktime(date('H') + 1, date('i'), date('s'), date('n'), date('j'), date('Y'));
            return true;
        } else {
            $_SESSION['user_session'] = false;
            $_SESSION['user_permisions'] = false;
            $_SESSION['user_session_ttl'] = false;
            return false;
        }
    }

    function logOut() {
        $_SESSION['user_session'] = false;
        $_SESSION['user_permisions'] = false;
        $_SESSION['user_session_ttl'] = false;
        return true;
    }

    function sessionActive() {
        if (isset($_SESSION['user_session']) && $_SESSION['user_session'] != 'ok') {
            return false;
        }

        if (!self::sessionTtl()) {
            return false;
        }
        return true;
    }

    function confirmAcl($_permiso = false) {


        if ($_permiso && !self::acl($_permiso)) {
            return false;
        }
    }

}

?>
