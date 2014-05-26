<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inicioController
 *
 * @author webmaster
 */
class reportesblhController extends Display {

    var $grid;
    var $data;
    var $gridPorcentaje;
    var $sqlRows;
    var $tableRows;

    function deploy() {
        $this->deployMainMenu();
        $this->deploySideMenu();
        //$this->deploySideMenu();
        $this->vista = "reportesblh";
        MasterController::requerirClase("MysqlSelect");
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if (method_exists($this, $action)) {
                $this->$action();
            }
        }


        require_once P_THEME . DS . "index.php";
    }

    function deploySideMenu() {
        $this->sideMenu = "";

        $this->sideMenu .= '
            <div class="span2 bs-docs-sidebar">
            <ul class="nav nav-list bs-docs-sidenav affix-top">              
              <li><a href="?v=reportesblh&action=viewDatosGenerales">Datos Generales</a></li>
              <li><a href="?v=reportesblh&action=viewRecoleccionLeche">Recolección de leche</a></li>
              <li><a href="?v=reportesblh&action=viewDatosGenerales">Producción</a></li>
              <li><a href="?v=reportesblh&action=viewDatosGenerales">Atención</a></li>
              <li><a href="?v=reportesblh&action=viewDatosGenerales">Producción Global</a></li>
            </ul>
            </div>';
    }

    public function viewReport() {
        
    }

    function getBasicInfoTable() {
        MasterController::requerirModelo("medicion_blh_info");
        $item = new medicion_blh_info();
        return $item->getList(Array(), Array());
    }

    function getProductionTable() {
        $init = $_POST['fechainicio'];
        $end = $_POST['fechafin'];

        MasterController::requerirClase("MysqlSelect");
        $ms = new MysqlSelect();
        $ms->setTableReference('medicion_blh_produccion m');
        $ms->addSelection("hospital", "nombre", "hospital");
        $ms->addCustomSelection("SUM(m.litros_leche_recolectada) as litros_leche_recolectada");
        $ms->addCustomSelection("SUM(m.litros_leche_distribuida) as litros_leche_distribuida");
        $ms->addCustomSelection("SUM(m.litros_leche_recolectada_extrahospitalaria) as litros_leche_recolectada_extrahospitalaria");
        $ms->addCustomSelection("SUM(m.litros_leche_recolectada_intrahospitalaria) as litros_leche_recolectada_intrahospitalaria");
        $ms->addCustomSelection("SUM(m.litros_leche_pasteurizada) as litros_leche_pasteurizada");
        $ms->addCustomSelection("SUM(m.litros_leche_descartada) as litros_leche_descartada");
        $ms->addCustomSelection("AVG(m.uso_leche_recolectada) as uso_leche_recolectada");
        $ms->addCustomSelection("SUM(m.rn_atendidos_ucip_neumo_rn) as rn_atendidos_ucip_neumo_rn");
        $ms->addCustomSelection("SUM(m.rn_tratados_leche_humana) as rn_tratados_leche_humana");
        $ms->addCustomSelection("AVG(m.cobertura_atencion) as cobertura_atencion");
        $ms->addCustomSelection("SUM(m.cantidad_partos_atendidos) as cantidad_partos_atendidos");
        $ms->addCustomSelection("SUM(m.cantidad_madres_donadoras) as cantidad_madres_donadoras");
        $ms->addCustomSelection("SUM(m.numero_madres_donadoras_internas) as numero_madres_donadoras_internas");
        $ms->addCustomSelection("SUM(m.numero_madres_donadoras_externas) as numero_madres_donadoras_externas");
        $ms->addCustomSelection("SUM(m.captacion_donadoras) as captacion_donadoras");
        $ms->addJoin("hospital", "hospital_id", "=", "m", "hospital_id", "LEFT");
        $ms->addFilter("m", "fecha_medicion", $init, ">=");
        $ms->addFilter("m", "fecha_medicion", $end, "<=");
        $ms->addGroup("hospital", "hospital_id");
        $ms->execute();

        $table = "
			<h3> Variables de producci&oacute;n</h3>
			<table class=\"table table-condensed table-bordered\">
				<tr>
					<th>Hospital</th>
					<th>Leche Recolectada (L)</th>
					<th>Leche Recolectada intra hospitalaria (L)</th>
					<th>Leche Recolectada extra hospitalaria (L)</th>
					<th>Leche Distribuida (L)</th>
					<th>Leche Pasteurizada (L)</th>
					<th>Leche Descartada (L)</th>
					<th>Uso de la leche recolectada</th>
					<th>RN Atendidos en UCIP / Neumologia / Recien Nacido</th>
					<th>RN tratados con Leche Humana</th>
					<th>cobertura_atencion</th>
					<th>Partos atendidos</th>
					<th>Madres donadoras</th>
					<th>Madres donadoras internas</th>
					<th>Madres donadoras externas</th>
					<th>Captacion de donadoras</th>
				</tr>
		";
        foreach ($ms->rows AS $row) {
            $table .="
					<tr>
					<td>{$row[hospital]}</td>
					<td>{$row[litros_leche_recolectada]}</td>
					<td>{$row[litros_leche_recolectada_intrahospitalaria]}</td>
					<td>{$row[litros_leche_recolectada_extrahospitalaria]}</td>
					<td>{$row[litros_leche_distribuida]}</td>
					<td>{$row[litros_leche_pasteurizada]}</td>
					<td>{$row[litros_leche_descartada]}</td>
					<td>{$row[uso_leche_recolectada]}</td>
					<td>{$row[rn_atendidos_ucip_neumo_rn]}</td>
					<td>{$row[rn_tratados_leche_humana]}</td>
					<td>{$row[cobertura_atencion]}</td>
					<td>{$row[cantidad_partos_atendidos]}</td>
					<td>{$row[cantidad_madres_donadoras]}</td>
					<td>{$row[numero_madres_donadoras_internas]}</td>
					<td>{$row[numero_madres_donadoras_externas]}</td>
					<td>{$row[captacion_donadoras]}</td>
				</tr>
				";
        }

        $table .="</table>";
        echo $table;
        die;

        //echo "<pre>"; print_r($ms->rows); echo "</pre>"; die;
        //return $item->getList(Array(),$filters);		
    }

    function returnOptions() {


        $this->loadContentView("getReferencias");
        $this->getContentView();
        die;
    }

    function visualizar() {
        /* 	
          $db = new dbexec();

          $db->queryExecute("select * from submision limit 10");
          if($db->error){ echo $db->error;}else{
          echo "<pre>";print_r($db->getArray());echo "<pre>";die;
          }

          /*
          $exsl =  new MysqlSelect();
          echo 'debug';
          $exsl->setTableReference("submision");
          echo 'debug2';
          $exsl->addSelection("submision", "submision_id");
          echo 'debug3';
          $exsl->addSelection("submision", "fecha");
          echo 'debug3';
          $exsl->addSelection("submision", "anio");
          echo 'debug4';
          $exsl->addSelection("submision", "mes");
          echo 'debug5';
          $exsl->addSelection("submision", "municipio_id");
          echo 'debug6';
          $exsl->execute();
          echo 'debug7 <br>';
          echo $exsl->error;
          echo 'debug8';
          ?>
          asdf
          <pre>
          <?php print_r($exsl->rows);?>
          </pre>
          <?php
          die;

         */


        if ($_POST['indicador_id'] == 0) {
            $this->visualizarAllIndicadores();
            return;
        }



        $val = new MysqlSelect();
        $sl = new MysqlSelect();
        $sl->addCustomSelection("count(submision.submision_id) AS ingresos");
        //$sl->addCustomSelection("submision.anio AS esteanio");				
        $val->setTableReference("valor_indicador");
        $val->addFilter("valor_indicador", "indicador_id", $_POST['indicador_id'], "=");
        $val->execute();

        $val->rows;
        $this->grid .= " ['Mes','Total',";
        $this->gridPorcentaje = " ['Mes',";
        $custmSel = "";
        foreach ($val->rows as $vr) {
            $this->grid .= " '{$vr[valor]}', ";
            $this->gridPorcentaje .= " '{$vr[valor]}', ";
            $sl->addCustomSelection("sum( if(valor_indicador.valor_indicador_id = {$vr[valor_indicador_id]},1,0) ) AS {$vr[valor]}");
        }
        $this->grid = substr($this->grid, 0, -2);
        $this->gridPorcentaje = substr($this->gridPorcentaje, 0, -2);

        $this->grid .= "],";
        $this->gridPorcentaje .= "],";

        $sl->setTableReference("submision");
        $sl->addSelection("fecha", "mes", "mes");
        $sl->addSelection("fecha", "anio", "anio");

        //$sl->addSelection("indicador", "nombre","indicador");
        $sl->addJoin("fecha", "fecha_id", "=", "submision", "fecha_id", "LEFT");
        $sl->addJoin("valor_indicador", "valor_indicador_id", "=", "submision", "valor_indicador_id", "LEFT");
        $sl->addJoin("indicador", "indicador_id", "=", "valor_indicador", "indicador_id", "LEFT");

        $sl->addFilter("fecha", "fecha_id", $_POST['fecha_id_init'], ">=");
        $sl->addFilter("fecha", "fecha_id", $_POST['fecha_id_end'], "<=");

        /* $sl->addFilter("submision", "anio", $_POST['anio-inicio'], ">=" );
          $sl->addFilter("submision", "anio", $_POST['anio-fin'], "<=" );
          $sl->addFilter("submision", "mes", $_POST['mes-inicio'], ">=");
          $sl->addFilter("submision", "mes", $_POST['mes-fin'], "<=");

          $conactDate = "CAST(CONCAT(submision.anio,'-',IF(submision.mes<10,CONCAT('0',submision.mes),submision.mes),'-','1') AS UNSIGNED)";
          $startAtDate=trim($_POST['anio-inicio'])."-".trim($_POST['mes-inicio'])."-". 1;
          $endAtDate=trim($_POST['anio-fin'])."-".trim($_POST['mes-fin'])."-". 1;

          //echo $startAtDate . " - " . $endAtDate; die;

          //$sl->addCustomSelection("{$conactDate} AS daterange");
          $sl->addCustomFilter("{$conactDate} >= '{$startAtDate}' AND {$conactDate} <= '{$endAtDate}'"); */

        if ($_POST['servicio_intrahospitalario_id'] != 'todos' && is_numeric($_POST['servicio_intrahospitalario_id'])) {
            $sl->addFilter("submision", "servicio_intrahospitalario_id", $_POST['servicio_intrahospitalario_id'], "=");
        }

        if ($_POST['hospital_id'] != 'todos' && is_numeric($_POST['hospital_id'])) {
            $sl->addFilter("submision", "hospital_id", $_POST['hospital_id'], "=");
        }

        //$sl->addFilter("servicio_intrahospitalario", "servicio_intrahospitalario_id", "=");
        //$sl->addFilter("submision", "mes", "<=", $_POST['mes_fin']);
        $sl->addFilter("indicador", "indicador_id", $_POST['indicador_id'], "=");
        $sl->addGroup("fecha", "mes");

        $sl->addGroup("indicador", "indicador_id");
        $sl->addOrderBy("fecha", "anio", "ASC");
        $sl->addOrderBy("fecha", "mes", "ASC");
        $sl->execute();
        //echo $sl->query; die; 
        //echo "<pre>"; print_r($sl); echo "</pre>"; die;
        if (count($sl->rows) > 0) {
            foreach ($sl->rows as $row) {
                if (is_array($row)) {
                    $totalSubs = $row['ingresos'];
                    $this->grid .= " ['" . $this->covertirAMes($row['mes']) . " - " . $row['anio'] . "',{$row[ingresos]}, ";
                    $this->gridPorcentaje .= " ['" . $this->covertirAMes($row['mes']) . " - " . $row['anio'] . "', ";
                    foreach ($row As $r => $value) {
                        if (( ($r != 'mes') && ($r != 'ingresos') ) && !is_numeric($r) && ($r != 'anio')) {
                            $this->grid .= "{$value}, ";

                            $porc = ($value * 100) / $totalSubs;
                            $this->gridPorcentaje .= "$porc, ";
                        }
                    }

                    $this->grid = substr($this->grid, 0, -2);
                    $this->grid .= " ],";

                    $this->gridPorcentaje = substr($this->gridPorcentaje, 0, -2);
                    $this->gridPorcentaje .= " ],";
                }
            }

            $this->grid = substr($this->grid, 0, -1);
            $this->gridPorcentaje = substr($this->gridPorcentaje, 0, -1);
            $this->sqlRows = $sl->rows;
        }



        //$this->grid;
        //echo $sl->query;
        //echo $sl->query;
        $this->loadContentView("viewReport");
    }

    function visualizarAllIndicadores() {

        MasterController::requerirClase("MysqlSelect");
        $vr = new MysqlSelect();
    }

    function viewLineaBasal() {
        $this->loadContentView("lineaBasal");
    }

    function generateLineaBasalTable() {
        $this->masterCtrl->requerirModelo("fecha");
        $fid = $_POST['fecha_id'];
        $eid = $_POST['estandar_id'];
        $iid = $_POST['indicador_id'];
        $date = new fecha();
        $date->setFechaId($fid);
        $date->getValuesBySetedId();

        if (empty($fid) || empty($eid) || empty($iid)) {
            echo "No se recibieron suficientes parametros";
            die;
        }

        MasterController::requerirClase("MysqlSelect");
        $sl = new MysqlSelect();
        $sl->setTableReference('submision');
        $sl->addSelection("hospital", "nombre", "hospital");  //addCustomSelection("h.nombre as hospital,")
        $sl->addSelection("fecha", "date", "fecha");
        $sl->addCustomSelection('sum( if(valor_indicador.valor = "si",1,0) ) AS SIS');
        $sl->addCustomSelection('sum( if(valor_indicador.valor = "no",1,0) ) AS NOS');
        $sl->addCustomSelection('sum( if(valor_indicador.valor = "no_aplica",1,0) ) AS NAS');
        $sl->addJoin("valor_indicador", "valor_indicador_id", "=", "submision", "valor_indicador_id", "left");
        $sl->addJoin("hospital", "hospital_id", "=", "submision", "hospital_id", "left");
        $sl->addJoin("fecha", "fecha_id", "=", "submision", "fecha_id", "left");
        $sl->addFilter("submision", "estandar_id", $eid, "=");
        $sl->addFilter("valor_indicador", "indicador_id", $iid, "=");
        $sl->addFilter("fecha", "date", $date->getDate(), ">=");
        $sl->addGroup("submision", "hospital_id");
        $sl->addGroup("submision", "fecha_id");
        $sl->addOrderBy("fecha", "date", "DESC");
        $sl->execute();

        //echo $sl->query; die;

        $hospitales = array();
        $fechas = array();
        $matriz = array();
        $table = "";

        foreach ($sl->rows as $row) {
            if (!in_array($row['hospital'], $hospitales)) {
                $hospitales[] = $row['hospital'];
            }
        }
        $tableHeader = "<tr><th width=\"250\">Hospital</th><th  width=\"90\"></th>";
        foreach ($sl->rows as $row) {
            if (!in_array($row['fecha'], $fechas)) {
                $fechas[] = $row['fecha'];
                $tableHeader .= "<th>" . $this->formatDate($row['fecha']) . "</th>";
            }
        }
        $tableHeader .="</tr>";

        $totalSiFecha = Array();
        $totalNoFecha = Array();
        $totalNaFecha = Array();

        foreach ($hospitales as $h) {
            foreach ($fechas as $f) {

                foreach ($sl->rows as $row) {
                    if ($row['hospital'] == $h && $row['fecha'] == $f) {
                        $totalSiFecha[$f] += $row['SIS'];
                        $totalNoFecha[$f] += $row['NOS'];
                        $totalNaFecha[$f] += $row['NAS'];
                        $matriz[$h][$f]["si"] = $row['SIS'];
                        $matriz[$h][$f]["no"] = $row['NOS'];
                        $matriz[$h][$f]["no_aplica"] = $row['NAS'];
                    } else {
                        if (!$matriz[$h][$f]["si"]) {
                            $matriz[$h][$f]["si"] = 0;
                            $matriz[$h][$f]["no"] = 0;
                            $matriz[$h][$f]["no_aplica"] = 0;
                        }
                    }
                }
            }
        }


        $tableHCell = "";
        foreach ($matriz as $h => $value) {
            $tableHCell .= "<tr>";
            $tableHCell .= "<td rowspan=\"3\">" . $h . "</td>";
            $tableHCellSi = "<td>Si</td>";
            $tableHCellNo = "<td>No</td>";
            $tableHCellNa = "<td>No Aplica</td>";
            foreach ($value as $fecha => $val) {
                $tableHCellSi .= "<td>" . $val['si'] . "</td>";
                $tableHCellNo .= "<td>" . $val['no'] . "</td>";
                $tableHCellNa .= "<td>" . $val['no_aplica'] . "</td>";
            }
            $tableHCell .= $tableHCellSi;
            $tableHCell .= "</tr>";

            $tableHCell .= "<tr>" . $tableHCellNo . "</tr>";
            $tableHCell .= "<tr>" . $tableHCellNa . "</tr>";
        }




        $tableFooter = "<tr><td rowspan=\"3\">Totales</td>";
        $footerSiCell = "<td>Si</td>";
        $footerNoCell = "<td>No</td>";
        $footerNaCell = "<td>No Aplica</td>";
        foreach ($fechas as $f) {
            $footerSiCell .= "<td>" . $totalSiFecha[$f] . "</td>";
            $footerNoCell .= "<td>" . $totalNoFecha[$f] . "</td>";
            $footerNaCell .= "<td>" . $totalNaFecha[$f] . "</td>";
        }
        $tableFooter .= $footerSiCell;
        $tableFooter .= "</tr>";

        $tableFooter .= "<tr>" . $footerNoCell . "</tr>";
        $tableFooter .= "<tr>" . $footerNaCell . "</tr>";



        echo "<table class=\"table table-bordered table-condensed \">" . $tableHeader . $tableHCell . $tableFooter . "</table>";
        die;
    }

    function formatDate($date) {
        $parts = explode("-", $date);
        $fecha = $this->covertirAMes($parts[1]) . "-" . $parts[0];
        return $fecha;
    }

    function generateLineaBasalTableToExcel() {
        header('Content-type: application/vnd.ms-excel');
        header('Content-disposition: attachment; filename="reporte-comparacion-indicadores.xls"');

        $this->generateLineaBasalTable();
    }

    function generateToExcel($action) {
        header('Content-type: application/vnd.ms-excel');
        header('Content-disposition: attachment; filename="reporte-comparacion-indicadores.xls"');

        $this->$action();
    }

    function viewDatosGenerales() {
        MasterController::requerirModelo("medicion_blh_info");
        $model = new medicion_blh_info();
        //$list = $model->getList(array(),array());
        //$this->_pre($list );

        $sl = new MysqlSelect();
        $sl->setTableReference("medicion_blh_info");
        $sl->addSelection("hospital", "nombre", "hospital");
        $sl->addSelection("medicion_blh_info", "nombre_coordinadora", "coordinador");
        $sl->addSelection("profesion_coordinadora_blh", "profesion", "profesion");
        $sl->addSelection("medicion_blh_info", "telefono");
        $sl->addSelection("medicion_blh_info", "email_contacto", "email");
        $sl->addSelection("medicion_blh_info", "cantidad_cunas_servicio_recien_nacido", "camas_rn");
        $sl->addSelection("medicion_blh_info", "inauguracion", "inauguracion");
        $sl->addSelection("medicion_blh_info", "fecha_primera_pasteurizacion", "primera_pasteurizacion");
        $sl->addSelection("medicion_blh_info", "dias_pasteurizacion_semanal", "dias_pasteurizacion_semana");
        $sl->addSelection("medicion_blh_info", "veces_pasteurizacion_diaria", "pasteurizaciones_diarias");
        $sl->addJoin("hospital", "hospital_id", "=", "medicion_blh_info", "hospital_id");
        $sl->addJoin("profesion_coordinadora_blh", "profesion_coordinadora_blh_id", "=", "medicion_blh_info", "profesion_coordinadora_blh_id");

        $sl->execute();
        $this->grid = $sl->rows;

        //$this->_pre($sl->rows);
        $this->loadContentView("datosGenerales");
    }

    function viewRecoleccionLeche() {
        $this->data = array();
        $sl = new MysqlSelect();
        $sl->setTableReference("medicion_blh_produccion");
        $sl->addCustomSelection("DISTINCT YEAR( medicion_blh_produccion.fecha_medicion ) AS anio");
        $sl->addOrderBy("medicion_blh_produccion", "fecha_medicion", "DESC");
        $sl->execute();
        $anios = array();
        if (is_array($sl->rows) && count($sl->rows) > 0) {
            foreach ($sl->rows AS $year) {
                $anios[] = $year['anio'];
            }
        }
        $this->data['year'] = $anios;

        //$this->_pre($anios);
        //$anos = 

        if (!$_GET['year'] || !$_GET['month']) {
            $this->loadContentView("recoleccionLeche");
        } else {
            $this->loadContentView("recoleccionLeche");
            MasterController::requerirModelo("medicion_blh_produccion");
            //$model = new medicion_blh_produccion();
            //$list = $model->getList(array(),array());
            //$this->_pre($list );

            $sl = new MysqlSelect();
            $sl->setTableReference("medicion_blh_produccion");
            $sl->addCustomSelection("   SUM(litros_leche_recolectada_intrahospitalaria) AS llri,
                                        SUM(litros_leche_recolectada_intrahospitalaria) AS llre");
            $sl->addCustomFilter("YEAR( medicion_blh_produccion.fecha_medicion ) = " . $_GET['year'] );            
            $sl->execute();
            //echo $sl->query;
            $this->data['gobal']['acumulado'] = $sl->rows[0];
            
            $sl = new MysqlSelect();
            $sl->setTableReference("medicion_blh_produccion");
            $sl->addCustomSelection("   SUM(litros_leche_recolectada_intrahospitalaria) AS llri,
                                        SUM(litros_leche_recolectada_extrahospitalaria) AS llre            
                                        ");
            $sl->addCustomFilter("YEAR( medicion_blh_produccion.fecha_medicion ) = " . $_GET['year'] 
                    . " AND MONTH( medicion_blh_produccion.fecha_medicion ) = " . $_GET['month'] ."");
            $sl->execute();
            //echo $sl->query;
            $this->data['gobal']['parcial'] = $sl->rows[0];
            
            
            
            
            $sl = new MysqlSelect();
            $sl->setTableReference("medicion_blh_produccion");
            $sl->addCustomSelection("   SUM(litros_leche_recolectada_intrahospitalaria) AS llri,
                                        SUM(litros_leche_recolectada_extrahospitalaria) AS llre,
                                        MONTH( medicion_blh_produccion.fecha_medicion ) AS mes
                                        ");
            $sl->addCustomFilter("YEAR( medicion_blh_produccion.fecha_medicion ) = " . $_GET['year'] . " GROUP BY mes ORDER BY mes ASC");
            $sl->execute();
            //$this->_pre($sl->rows);
            $this->data['mensual']= $sl->rows;
            
            
            $sl = new MysqlSelect();
            $sl->setTableReference("medicion_blh_produccion");
            $sl->addCustomSelection("   SUM(litros_leche_recolectada_intrahospitalaria) AS llri,
                                        SUM(litros_leche_recolectada_extrahospitalaria) AS llre,
                                        hospital.nombre,
                                        SUM(IF(MONTH(medicion_blh_produccion.fecha_medicion)='".$_GET['month']."', litros_leche_recolectada_intrahospitalaria,0) ) AS llrim,
                                        SUM(IF(MONTH(medicion_blh_produccion.fecha_medicion)='".$_GET['month']."', litros_leche_recolectada_extrahospitalaria,0) ) AS llrem
                                        ");            
            $sl->addCustomFilter("YEAR( medicion_blh_produccion.fecha_medicion ) = " . $_GET['year'] . " GROUP BY hospital.nombre");
            
            $sl->addJoin("hospital", "hospital_id", "=", "medicion_blh_produccion" , "hospital_id", "LEFT");
            $sl->execute();
            //$this->_pre($sl->rows);
            $this->data['porhospital']= $sl->rows;
        }
        
    }
    
    
    function viewRecoleccionLecheASDF() {
        $this->data = array();
        $sl = new MysqlSelect();
        $sl->setTableReference("medicion_blh_produccion");
        $sl->addCustomSelection("DISTINCT YEAR( medicion_blh_produccion.fecha_medicion ) AS anio");
        $sl->addOrderBy("medicion_blh_produccion", "fecha_medicion", "DESC");
        $sl->execute();
        $anios = array();
        if (is_array($sl->rows) && count($sl->rows) > 0) {
            foreach ($sl->rows AS $year) {
                $anios[] = $year['anio'];
            }
        }
        $this->data['year'] = $anios;

        //$this->_pre($anios);
        //$anos = 

        if (!$_GET['year'] || !$_GET['month']) {
            $this->loadContentView("recoleccionLeche");
        } else {
            $this->loadContentView("recoleccionLeche");
            MasterController::requerirModelo("medicion_blh_produccion");
            //$model = new medicion_blh_produccion();
            //$list = $model->getList(array(),array());
            //$this->_pre($list );

            $sl = new MysqlSelect();
            $sl->setTableReference("medicion_blh_produccion");
            $sl->addCustomSelection("   SUM(litros_leche_recolectada) AS llr,
                                        SUM(litros_leche_pasteurizada) AS llp,
                                        SUM(litros_leche_distribuida) AS lld,
                                        SUM(litros_leche_descartada) AS lldes,
                                        SUM(stock) AS stock"
                    );
            $sl->addCustomFilter("YEAR( medicion_blh_produccion.fecha_medicion ) = " . $_GET['year'] );            
            $sl->execute();
            //echo $sl->query;
            $this->data['gobal']['acumulado'] = $sl->rows;
            
            $sl = new MysqlSelect();
            $sl->setTableReference("medicion_blh_produccion");
            $sl->addCustomSelection("   SUM(litros_leche_recolectada) AS llr,
                                        SUM(litros_leche_pasteurizada) AS llp,
                                        SUM(litros_leche_distribuida) AS lld,
                                        SUM(litros_leche_descartada) AS lldes,
                                        SUM(stock) AS stock"
                    );
            $sl->addCustomFilter("YEAR( medicion_blh_produccion.fecha_medicion ) = " . $_GET['year'] . " AND MONTH( medicion_blh_produccion.fecha_medicion ) = " . $_GET['month']);            
            $sl->execute();
            //echo $sl->query;
            $this->data['gobal']['mes'] = $sl->rows;
            
            //$this->_pre($sl->rows);
        }
        
    }
    
    function getProductionMonthsByYear(){
        
        $this->data = array();
        $sl = new MysqlSelect();
        $sl->setTableReference("medicion_blh_produccion");
        $sl->addCustomSelection("DISTINCT MONTH( medicion_blh_produccion.fecha_medicion ) AS mes");
        $sl->addCustomFilter(" YEAR( medicion_blh_produccion.fecha_medicion ) = " . $_GET['year']);        
        $sl->execute();
        $meses = array();
        $string = "";
        if (is_array($sl->rows) && count($sl->rows) > 0) {
            foreach ($sl->rows AS $mes) {
                $meses[] = $mes['mes'];
                $string .='<option value="' . $mes['mes'] . '">' . $this->monthName($mes['mes']) . '</option>';
            }
        }
        
        
        
        echo $string;
        die;
    }

    function _pre($var, $die = true) {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
        if ($die) {
            die;
        }
    }

}

?>
