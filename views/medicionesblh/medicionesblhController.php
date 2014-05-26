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
class medicionesblhController extends Display {

    var $grid;
    var $rowsCount;

    function deploy() {
        $this->params = array();
        $this->deployMainMenu();
        $this->deploySideMenu();
        $this->vista = "medicionesblh";
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if (method_exists($this, $action)) {
                $this->$action();
            }
        } else {
            $this->masterCtrl->requerirModelo("hospital");
            $hsp = new hospital();
            if (isset($_GET['idh'])) {
                $hsp->setHospitalId($_GET['idh']);
                $hsp->getValuesBySetedId();
                $this->passParam("hospital", $hsp);
            } else {
                $this->alertMsg = "<h4>Alerta!</h4> No se han recibido el identificador del hospital";
            }
        }


        require_once P_THEME . DS . "index.php";
    }

    function deploySideMenu() {
        $this->sideMenu = "";
    }

    /*
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
     */

    function submitBasicInfoTEST() {
        echo ' 
                <div class="alert alert-success" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Éxito!</h4>
                  Medición guardada con exito!!
                </div>
            ';

        die;
    }

    function submitBasicInfo() {
        if (
                !isset($_POST['hospital_id'])
        ) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Ooops!</h4>
                  Error guardando la medición de información básica <br />
                  El campo -- Hospital -- es obligatorio
                </div>
            ';
            die;
        }

        if (
                !isset($_POST['cantidad_cunas_servicio_recien_nacido']) ||
                !is_numeric($_POST['cantidad_cunas_servicio_recien_nacido'])
        ) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Ooops!</h4>
                  Error guardando la medición de información básica <br />
                  El campo -- Cunas en servicio de recien nacido -- debe ser un numero entero
                </div>
            ';
            die;
        }

        if (
                !isset($_POST['cantidad_camas_maternidad']) ||
                !is_numeric($_POST['cantidad_camas_maternidad'])
        ) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Ooops!</h4>
                  Error guardando la medición de información básica <br />
                  El campo -- Camas de maternidad -- debe ser un numero entero
                </div>
            ';
            die;
        }

        if (
                empty($_POST['nombre_coordinadora'])
        ) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Ooops!</h4>
                  Error guardando la medición de información básica <br />
                  El campo -- Nombre de la coordinadora -- es obligatorio
                </div>
            ';
            die;
        }
        //echo "<pre>"; print_r($_POST); echo "</pre>"; die;
        if ($_POST['isnew'] == "isnew") {
            $this->saveBasicInfo();
        } else {
            $this->updateBasicInfo();
        }
    }

    function saveBasicInfo() {

        //echo "<pre>"; print_r($_POST); echo "</pre>"; die;

        $this->masterCtrl->requerirModelo("medicion_blh_info");
        $item = new medicion_blh_info();
        $item->postToObject();
        $item->setFecha(date("Y-m-d"));
        //$item->setHospitalId($_POST['hid']);
        $this->transaction->loadClass($item);
        //echo $this->transaction->save(false, true);die;
        if ($this->transaction->save()) {
            echo ' 
                <div class="alert alert-success" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Éxito!</h4>
                  Medición de informaci&oacute;n B&aacute;sica guardada con exito!!
                </div>
            ';
        } else {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Error guardando la medición de información básica
                </div>
            ';
        }
        die;
    }

    function updateBasicInfo() {

        //echo "<pre>"; print_r($_POST); echo "</pre>"; die;

        $this->masterCtrl->requerirModelo("medicion_blh_info");
        $item = new medicion_blh_info();
        $item->postToObject();
        $item->setFecha(date("Y-m-d"));
        $this->transaction->loadClass($item);
        //echo $this->transaction->save(false, true);die;
        if ($this->transaction->update()) {
            echo ' 
                <div class="alert alert-success" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Éxito!</h4>
                  Medición de informaci&oacute;n B&aacute;sica editada con exito!!
                </div>
            ';
        } else {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Error editando la medición de información básica
                </div>
            ';
        }
        die;
    }

    function submitProduccion() {
        //echo "<pre>"; print_r($_POST); echo "</pre>"; die;
        $this->masterCtrl->requerirModelo("medicion_blh_produccion");
        $item = new medicion_blh_produccion();
        $item->postToObject();
        $hoy = date("Y-m-d") . "";
        $item->setFecha($hoy);
        $fmedicion = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-01");
        $fmedicionLimit = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-10");
        $item->setFechaMedicion($fmedicion);
        if ($item->getFecha() > $fmedicionLimit) {
            $item->setMedicionTardia(1);
        } else {
            $item->setMedicionTardia(0);
        }
        $item->setCantidadMadresDonadoras($_POST['numero_madres_donadoras_internas'] + $_POST['numero_madres_donadoras_externas']);

        /* echo "<pre>";
          print_r($item);
          echo "</pre>";die; */

        /* echo "<pre>";
          print_r($item->validateObject());
          echo "</pre>";die; */
        if (!$item->validateObject()) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Faltan datos, por favor ingrese todos los campos
                </div>
            ';
            die;
        }

        $this->transaction->loadClass($item);
        if ($this->transaction->save()) {
            echo ' 
                <div class="alert alert-success" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Éxito!</h4>
                  Medición producción guardada con exito!!
                </div>
            ';
        } else {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Error guardando la medición de producción
                </div>
            ';
        }


        //print_r($item);

        die;
    }
    
    function submitCalidad(){
        $this->masterCtrl->requerirModelo("medicion_blh_calidad");
        $item = new medicion_blh_calidad();
        $item->postToObject();
        $hoy = date("Y-m-d") . "";
        $item->setFecha($hoy);
        $fmedicion = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-01");
        $fmedicionLimit = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-10");
        $item->setFechaMedicion($fmedicion);
        if ($item->getFecha() > $fmedicionLimit) {
            $item->setMedicionTardia(1);
        } else {
            $item->setMedicionTardia(0);
        }
        
        $item->setCantidadAnalisisAcidezDormic($_POST['cantidad_aceptable_acidez_dormic'] + $_POST['cantidad_no_aceptable_acidez_dormic']);
        //$item->setCantidadAnalisisCrematocrito($_POST['cantidad_aceptable_crematocrito'] + $_POST['cantidad_no_aceptable_crematocrito']);
        $item->setCantidadAnalisisColiformes($_POST['cantidad_aceptable_coliformes'] + $_POST['cantidad_no_aceptable_coliformes']);
        /*  
            echo "<pre>";
            print_r($item);
            echo "</pre>";die; 
        */
        /* echo "<pre>";
          print_r($item->validateObject());
          echo "</pre>";die; */
        if (!$item->validateObject()) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Faltan datos, por favor ingrese todos los campos
                </div>
            ';
            die;
        }

        $this->transaction->loadClass($item);
        if ($this->transaction->save()) {
            echo ' 
                <div class="alert alert-success" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Éxito!</h4>
                  Medición de calidad guardada con exito!!
                </div>
            ';
        } else {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Error guardando la medición de calidad
                </div>
            ';
        }


        //print_r($item);

        die;
    }
    
    
    function submitFuncionamientoMensual(){
        $this->masterCtrl->requerirModelo("medicion_blh_funcionamiento_mensual");
        $item = new medicion_blh_funcionamiento_mensual();
        $item->postToObject();
        $hoy = date("Y-m-d") . "";
        $item->setFecha($hoy);
        $fmedicion = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-01");
        $fmedicionLimit = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-10");
        $item->setFechaMedicion($fmedicion);
        if ($item->getFecha() > $fmedicionLimit) {
            $item->setMedicionTardia(1);
        } else {
            $item->setMedicionTardia(0);
        }
        
        /*echo "<pre>";
          print_r($item);
          echo "</pre>";die; */

        /* echo "<pre>";
          print_r($item->validateObject());
          echo "</pre>";die; */
        if (!$item->validateObject()) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Faltan datos, por favor ingrese todos los campos
                </div>
            ';
            die;
        }

        $this->transaction->loadClass($item);
        if ($this->transaction->save()) {
            echo ' 
                <div class="alert alert-success" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Éxito!</h4>
                  Medición de funcionamiento mensual guardada con exito!!
                </div>
            ';
        } else {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Error guardando la medición de funcionamiento mensual
                </div>
            ';
        }


        //print_r($item);

        die;
    }
    
    
    
    function submitFuncionamientoAnual(){
        $this->masterCtrl->requerirModelo("medicion_blh_funcionamiento_anual");
        $item = new medicion_blh_funcionamiento_anual();
        $item->postToObject();
        $hoy = date("Y-m-d") . "";
        $item->setFecha($hoy);
        $fmedicion = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-01");
        $fmedicionLimit = $this->stringToDate($_POST['anio'] . "-" . $_POST['mes'] . "-10");
        $item->setFechaMedicion($fmedicion);
        if ($item->getFecha() > $fmedicionLimit) {
            $item->setMedicionTardia(1);
        } else {
            $item->setMedicionTardia(0);
        }
        
        /*echo "<pre>";
          print_r($item);
          echo "</pre>";die; */

        /* echo "<pre>";
          print_r($item->validateObject());
          echo "</pre>";die; */
        if (!$item->validateObject()) {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Faltan datos, por favor ingrese todos los campos
                </div>
            ';
            die;
        }

        $this->transaction->loadClass($item);
        if ($this->transaction->save()) {
            echo ' 
                <div class="alert alert-success" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Éxito!</h4>
                  Medición de funcionamiento anual guardada con exito!!
                </div>
            ';
        } else {
            echo ' 
                <div class="alert alert-error" id="alertResponseBox">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>¡Error!</h4>
                  Error guardando la medición de funcionamiento anual
                </div>
            ';
        }


        //print_r($item);

        die;
    }
    

    function viewUpdateForm() {
        $this->loadContentView("updateForm");
    }

    function update() {
        //echo "<pre>"; print_r($_POST); echo "<pre>";


        if (!$_POST) {
            $this->alert = true;
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido datos";
            $this->loadContentView("default");
            return false;
        }

        if (!$_POST['nombre']) {
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estandar son obligatorios";
            $this->loadContentView("default");
            return false;
        }

        if (!$_POST['estandar_id']) {
            $this->error = true;
            $this->errorMsg = "<h4>Campos incompletos!</h4>Los datos de nombre y estandar son obligatorios";
            $this->loadContentView("default");
            return false;
        }


        MasterController::requerirModelo("indicador");
        $item = new indicador();
        if ($_POST['indicador_id'] != '') {
            $item->indicador_id['val'] = $_POST['indicador_id'];
        }

        if ($_POST['estandar_id'] != '') {
            $item->estandar_id['val'] = $_POST['estandar_id'];
        }

        if ($_POST['nombre'] != '') {
            $item->nombre['val'] = $_POST['nombre'];
        }


        $item->descripcion['val'] = $_POST['descripcion'];


        $this->transaction->loadClass($item);

        //echo $this->transaction->update();
        if ($this->transaction->update()) {
            $this->done = true;
            $this->doneMsg = "Indicador {$_POST[nombre]} editado con exito";
            $this->loadContentView("default");
            return true;
        } else {
            $this->loadContentView("default");
            return false;
        }
    }

    function returnOptions() {
        $this->loadContentView("getReferencias");
        $this->getContentView();
        die;
    }

    function formInfoBasica() {
        //sleep(3);
        $this->loadContentView("infoBasicaForm");
        $this->getContentView();
        die;
    }

    function verListadoHospitales() {
        $this->loadContentView("listadoHospitales");
    }

    function verIngresoMediciones() {
        $this->loadContentView("mediciones");
    }

    function viewMedicionesForms() {
        $this->masterCtrl->requerirModelo("hospital");
        $hsp = new hospital();
        if (isset($_GET['idh'])) {
            $hsp->setHospitalId($_GET['idh']);
            $hsp->getValuesBySetedId();
            $this->passParam("hospital", $hsp);
        } else {
            $this->alertMsg = "<h4>Alerta!</h4> No se han recibido el identificador del hospital";
        }
        $this->loadContentView("default");
        $this->getContentView();
        die;
    }

    function getAvailableMonths() {
        if (isset($_GET['idh']) && isset($_GET['anio']) && isset($_GET['medicion'])) {
            $modelName = "";
            $yearMonths = Array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
            switch ($_GET['medicion']) {
                case "calidad":
                    $modelName = "medicion_blh_calidad";
                    break;
                case "produccion":
                    $modelName = "medicion_blh_produccion";
                    break;
                case "funcionamiento":
                    $modelName = "medicion_blh_funcionamiento_mensual";
                    break;
                case "func-semestral":
                    $modelName = "medicion_blh_funcionamiento_semestral";
                    break;
            }

            $this->masterCtrl->requerirModelo($modelName);
            $model = new $modelName();
            
            $this->masterCtrl->requerirClase("MysqlSelect");
            $sl = new MysqlSelect();
            $tb = $model->getReference();
            
            $sl->setTableReference($tb);
            $sl->addSelection($tb, "fecha_medicion");
            $sl->addFilter($tb, "fecha_medicion", $_GET['anio'] . "-01-01", ">=");
            $sl->addFilter($tb, "fecha_medicion", $_GET['anio'] . "-12-31", "<=");
            $sl->addFilter($tb, "hospital_id", $_GET['idh'] , "=");
            
            $sl->execute();            



            if ($sl->rowsCount()) {
                
                $months = array();
                foreach ($sl->rows AS $d => $date ) {
                    $parts = explode("-", $date[0]);
                    $index = $parts[1] * 1;
                    $months[$index] = $index;
                }
                //echo json_encode($months); die;
                $monthsAvaliables = array_diff($yearMonths, $months);
                //echo json_encode($monthsAvaliables); die;
                foreach ($monthsAvaliables AS $mt => $mn ) {
                    echo "<option value=\"".$mn."\">" . $this->monthName($mn) . "</option>";
                }
                
                die;
            } else {
                for($m = 1; $m <= 12; $m++ ) {
                    echo "<option value=\"".$m."\">" . $this->monthName($m) . "</option>";
                }
                die;
            }

            die;
        } else {
            
        }
    }
    
    function getAvailableYears($idh) {
        $this->masterCtrl->requerirModelo("medicion_blh_funcionamiento_anual");
        $model = new medicion_blh_funcionamiento_anual();
        $selection = array("anio");
        $filters = array("hospital_id" => Array($idh,"="));
        $anios = $model->getList($selection, $filters);
        $return = array();
        foreach($anios AS $year){
            $return[] = $year[0];
        }
        return $return;
        
        
    }
    
    
    

    function stringToDate($date) {
        $time = strtotime($date);
        return date('Y-m-d', $time);
    }
    
    function getLastStock(){
        $idh = $_GET['idh'];
        $month = $_GET['month'];
        $year = $_GET['year'];
        $date = "{$year}-{$month}-01";
        
        $sl = new MysqlSelect();
        
        $sl->setTableReference("medicion_blh_produccion");
        $sl->addSelection("medicion_blh_produccion", "stock");
        $sl->addSelection("medicion_blh_produccion", "stock_leche_pasteurizada");
        $sl->addFilter("medicion_blh_produccion", "fecha_medicion", $date, "<");
        $sl->addSimpleLimit(1);
        $sl->addOrderBy("medicion_blh_produccion", "fecha_medicion","DESC");
        $sl->execute();
        $stocks =  array();
        //echo $sl->query;
        //die;
        if($sl->rowsCount() > 0){
            //echo "<pre>"; print_r($sl->rows); echo "</pre>"; die;
            
            $stocks["stock"] = ($sl->rows[0]['stock']) ? $sl->rows[0]['stock'] : 0;
            $stocks["stock_pasteurizada"] = ($sl->rows[0]['stock_leche_pasteurizada']) ? $sl->rows[0]['stock_leche_pasteurizada'] : 0;
            
        }else{
            $stocks["stock"] = 0;
            $stocks["stock_pasteurizada"] = 0;            
        }        
        echo json_encode($stocks);
        die;
    }
    
    function getLastTotalLeche(){
        $idh = $_GET['idh'];
        $month = $_GET['month'];
        $year = $_GET['year'];
        $date = "{$year}-{$month}-01";
        
        $sl = new MysqlSelect();
        
        $sl->setTableReference("medicion_blh_produccion");
        $sl->addSelection("medicion_blh_produccion", "litros_leche_recolectada");        
        $sl->addFilter("medicion_blh_produccion", "fecha_medicion", $date, "<=");
        $sl->addSimpleLimit(1);
        $sl->addOrderBy("medicion_blh_produccion", "fecha_medicion","DESC");
        $sl->execute();
        $stocks =  array();
        //echo $sl->query;
        //die;
        if($sl->rowsCount() > 0){
            //echo "<pre>"; print_r($sl->rows); echo "</pre>"; die;
            
            $stocks["lecheRecolectada"] = ($sl->rows[0]['litros_leche_recolectada']) ? $sl->rows[0]['litros_leche_recolectada'] : 0;            
            
        }else{
            $stocks["lecheRecolectada"] = 0;            
        }        
        echo json_encode($stocks);
        die;
    }
    

}

?>
