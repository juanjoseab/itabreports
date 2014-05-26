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
class reportesController extends Display {

    var $grid;
    var $data;
    var $gridPorcentaje;
    var $sqlRows;
    var $tableRows;

    function deploy() {
        $this->deployMainMenu();
        //$this->deploySideMenu();
        $this->vista = "reportes";
        MasterController::requerirClase("MysqlSelect");
        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
            if (method_exists($this, $action)) {
                $this->$action();
            }
        }


        require_once P_THEME . DS . "index.php";
    }

    function getIndicadores() {
        if ($_POST['estandar']) {
            $estandar_id = $_POST['estandar'];
            MasterController::requerirClase("MysqlSelect");
            $sl = new MysqlSelect();
            $sl->setTableReference("indicador");
            $sl->addFilter("indicador", "estandar_id", $estandar_id, "=");
            $sl->execute();
            if ($sl->rowsCount() > 0) {
                
            }
        }
    }

    function returnOptions() {


        $this->loadContentView("getReferencias");
        $this->getContentView();
        die;
    }

    function visualizar() {
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

        //Query para ir a traer todos los id SI y NO de la tabla VALOR_INDICADOR, para todos los indicadores de un estandar (el que mandan por POST)
        //Con estos creo un ciclo para llenar los CASE del query que consolida todos los datos mas abajo.
        $vr->setTableReference("valor_indicador");
        $vr->addSelection('valor_indicador', 'valor_indicador_id');
        $vr->addSelection('indicador', 'indicador_id');

        $vr->addCustomSelection("SUM(IF(UPPER(valor_indicador.valor) = 'SI',1,0)) AS Si");
        $vr->addCustomSelection("SUM(IF(UPPER(valor_indicador.valor) = 'NO',1,0)) AS No");
        $vr->addJoin("indicador", "indicador_id", "=", "valor_indicador", "indicador_id", "LEFT");
        $vr->addFilter("indicador", "estandar_id", $_POST['estandar_id'], "=");
        $vr->addCustomFilter("(UPPER(valor_indicador.valor) = 'NO' OR UPPER(valor_indicador.valor) = 'SI')", "AND");
        $vr->addGroup("indicador", "indicador_id");
        $vr->addGroup("valor_indicador", "valor_indicador_id");

        //Verificar si se ejecuta el query y si existen datos.
        //Si los datos existen se van creando la cadena de los CASE.
        if ($vr->execute()) {
            if (count($vr->rows)) {
                $idsSiCase = "";
                $idsNoCase = "";
                foreach ($vr->rows as $row) {
                    if ($row['Si'] == 1) {
                        $idsSiCase .= "\r 
                            WHEN valor_indicador.valor_indicador_id = {$row[valor_indicador_id]} THEN 1 ";
                    } elseif ($row['No'] == 1) {
                        $idsNoCase .= "\r 
                            WHEN valor_indicador.valor_indicador_id = {$row[valor_indicador_id]} THEN 1 ";
                    }
                }
            }
        } else {
            echo "error ejecuntando el query : " . $vr->query;
            exit;
        }
        //echo $vr->query ."<hr />";

        $sl = new MysqlSelect();
        $sl->setTableReference('submision');
        $sl->addSelection("indicador", "nombre", "indicador");

        if (strlen(trim($idsNoCase)) > 0) {
            $sl->addCustomSelection("SUM( CASE
                                    {$idsNoCase}
                                    ELSE 0
                                    END
                                ) AS No");
        }

        if (strlen(trim($idsSiCase)) > 0) {
            $sl->addCustomSelection("SUM( CASE
                                    {$idsSiCase}
                                    ELSE 0
                                    END
                                ) AS Si");
        }

        //Agrego los joins de las tablas para filtrado, como los valores de las submisiones, los id de los indicadores y por ultimo el estandar indicado.
        $sl->addJoin("valor_indicador", "valor_indicador_id", "=", "submision", "valor_indicador_id", "LEFT");
        $sl->addJoin("indicador", "indicador_id", "=", "valor_indicador", "indicador_id", "LEFT");
        $sl->addJoin("estandar", "estandar_id", "=", "indicador", "estandar_id", "LEFT");


        //Filtro por el año, el mes de inicio y el mes de fin
        /*
          $sl->addFilter("submision", "anio", $_POST['anio-inicio'], ">=" );
          $sl->addFilter("submision", "anio", $_POST['anio-fin'], "<=" );
          $sl->addFilter("submision", "mes", $_POST['mes-inicio'], ">=");
          $sl->addFilter("submision", "mes", $_POST['mes-fin'], "<=");
         */

        $conactDate = "CAST(CONCAT(submision.anio,submision.mes,'1') AS UNSIGNED)";
        $startAtDate = $_POST['anio-inicio'] . $_POST['mes-inicio'] . 1;
        $endAtDate = $_POST['anio-fin'] . $_POST['mes-fin'] . 1;

        //$sl->addCustomSelection("{$conactDate} AS daterange");
        $sl->addCustomFilter("{$conactDate} >= {$startAtDate} AND {$conactDate} <= {$endAtDate}");

        //verifico si quieren filtrar por un servicio intra-hospitalario especifico
        if ($_POST['servicio_intrahospitalario_id'] != 'todos' && is_numeric($_POST['servicio_intrahospitalario_id'])) {
            $sl->addFilter("submision", "servicio_intrahospitalario_id", $_POST['servicio_intrahospitalario_id'], "=");
        }

        //verifico si quieren filtrar por un hospital en especifico
        if ($_POST['hospital_id'] != 'todos' && is_numeric($_POST['hospital_id'])) {
            $sl->addFilter("submision", "hospital_id", $_POST['hospital_id'], "=");
        }

        //Filtro para el estandar indicado
        $sl->addFilter("estandar", "estandar_id", $_POST['estandar_id'], "=");

        //Agrupo por el indicador para crear las sumas dadas.
        $sl->addGroup("indicador", "indicador_id");

        //Ejecuto el query y construyo el Arreglo de JavaScript para el chart
        if ($sl->execute()) {

            if (count($sl->rows)) {
                $this->grid = " ['Indicador','Si','No'],";
                foreach ($sl->rows as $row) {
                    //Guardo los datos en una variable de la clase para poder pasarla a la vista.
                    $this->grid .= " ['{$row[indicador]}',$row[Si],$row[No]],";
                }
            }
        }
        //Elimino el ultimo caracter del arreglo que es una coma (,) para evitar errores de javascritp
        $this->grid = substr($this->grid, 0, -1);

        //paso a travez de la propiedad del objeto $sqlRows el arreglo con el resultset del query para usarlo para crear una tabla en la vista      
        $this->sqlRows = $sl->rows;


        //echo $sl->query;

        $this->loadContentView("AllIndicadores");
    }

    function covertirAMes($numMes) {
        $NombreMes = "";
        if ($numMes && is_numeric($numMes)) {
            switch ($numMes) {
                case 1: $NombreMes = "Enero";
                    break;
                case 2: $NombreMes = "Febrero";
                    break;
                case 3: $NombreMes = "Marzo";
                    break;
                case 4: $NombreMes = "Abril";
                    break;
                case 5: $NombreMes = "Mayo";
                    break;
                case 6: $NombreMes = "Junio";
                    break;
                case 7: $NombreMes = "Julio";
                    break;
                case 8: $NombreMes = "Agosto";
                    break;
                case 9: $NombreMes = "Septiembre";
                    break;
                case 10: $NombreMes = "Octubre";
                    break;
                case 11: $NombreMes = "Noviembre";
                    break;
                case 12: $NombreMes = "Diciembre";
                    break;
            }
            return $NombreMes;
        }
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
        $sl->addOrderBy("fecha", "date", "ASC");
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
        $countHospital = 0;
        foreach ($hospitales as $h) {
            $countHospital++;
            foreach ($fechas as $f) {

                foreach ($sl->rows as $row) {
                    if ($row['hospital'] == $h && $row['fecha'] == $f) {
                        
                        $totalIndicadoresSuma = $row['SIS'] + $row['NOS'] + $row['NAS'];
                        $matriz[$h][$f]["si"] = number_format((float)($row['SIS'] / $totalIndicadoresSuma * 100), 2, '.', '');
                        $matriz[$h][$f]["no"] = number_format((float)($row['NOS'] / $totalIndicadoresSuma * 100), 2, '.', '');
                        $matriz[$h][$f]["no_aplica"] = number_format((float)($row['NAS'] / $totalIndicadoresSuma * 100), 2, '.', '');
                        
                        
                        $totalSiFecha[$f] += $matriz[$h][$f]["si"];
                        $totalNoFecha[$f] += $matriz[$h][$f]["no"];
                        $totalNaFecha[$f] += $matriz[$h][$f]["no_aplica"];
                        
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
                $tableHCellSi .= "<td>" . $val['si'] . "%</td>";
                $tableHCellNo .= "<td>" . $val['no'] . "%</td>";
                $tableHCellNa .= "<td>" . $val['no_aplica'] . "%</td>";
            }
            $tableHCell .= $tableHCellSi;
            $tableHCell .= "</tr>";

            $tableHCell .= "<tr>" . $tableHCellNo . "</tr>";
            $tableHCell .= "<tr>" . $tableHCellNa . "</tr>";
        }




        $tableFooter = "<tr><td rowspan=\"3\">Promedio Totales</td>";
        $footerSiCell = "<td>Si</td>";
        $footerNoCell = "<td>No</td>";
        $footerNaCell = "<td>No Aplica</td>";
        foreach ($fechas as $f) {
            $promedioSi = number_format((float)($totalSiFecha[$f] / $countHospital),2);
            $promedioNo = number_format((float)($totalNoFecha[$f] / $countHospital),2);
            $promedioNa = number_format((float)($totalNaFecha[$f] / $countHospital),2);
            $footerSiCell .= "<td>" . $promedioSi . "%</td>";
            $footerNoCell .= "<td>" . $promedioNo. "%</td>";
            $footerNaCell .= "<td>" . $promedioNa . "%</td>";
        }
        $tableFooter .= $footerSiCell  ;
        $tableFooter .= "</tr>";

        $tableFooter .= "<tr>" . $footerNoCell  . "</tr>";
        $tableFooter .= "<tr>" . $footerNaCell  . "</tr>";


        echo "<h3>Porcentajes de cumplimiento de estándares hospitalarios</h3>";
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

}

?>
