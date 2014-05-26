<?php
MasterController::requerirModelo("fecha");
$fecha = new fecha();
$finit = new fecha();
$fend = new fecha();
$finit->setFechaId($_POST['fecha_id_init']);
$fend->setFechaId($_POST['fecha_id_end']);
$finit->getValuesBySetedId();
$fend->getValuesBySetedId();
$fechas = $fecha->getList(array(),array());

?>
<script type="text/javascript" language="JavaScript">
    
    $(function(){
        $("#nuevoReporteForm").hide();
        $("a#linkVerNuevoReporte").click(function(){
            $("#nuevoReporteForm").slideToggle();
        });
        $("select#select_departamaento_combo_box").change(function(){
            $("select#select_municipio_combo_box option").remove();
            $.ajax({
                url:        '?v=reportes&action=returnOptions&referencia=municipios&itemId='+$(this).val(),
                type:       'GET',
                data:       '',
                success:    function(res){
                    $("select#select_municipio_combo_box").append(res);
                }
            });
        })
        
        
        $("select#select_estandar_combo_box").change(function(){
            $("select#select_intrahosp_combo_box option").remove();
            $.ajax({
                url:        '?v=reportes&action=returnOptions&referencia=servicios&itemId='+$(this).val(),
                type:       'GET',
                data:       '',
                success:    function(res){
                    $("select#select_intrahosp_combo_box").append(res);
                }
            });
            
            $.ajax({
                url:        '?v=reportes&action=returnOptions&referencia=indicadores&itemId='+$(this).val(),
                type:       'GET',
                data:       '',
                success:    function(res){
                    $("select#select_indicador_combo_box option").remove();
                    $("select#select_indicador_combo_box").append(res);
                }
            });            
        })
    })
        
</script>
    

<?php
//año
//mes inicio y fin
// estandar
// indicador
// servicio intrahosp
// hosp
MasterController::requerirModelo("estandar");
MasterController::requerirModelo("indicador");
MasterController::requerirModelo("servicio_intrahospitalario");
MasterController::requerirModelo("hospital");
$tx = new ClassTransaction();
$estandar = new estandar();
$indicador = new indicador();
$servh = new servicio_intrahospitalario();
$hospital = new hospital();

$estandar->estandar_id = $_POST['estandar_id'];
$tx->loadClass($estandar);
$si = $tx->returnObjectValues();
$estandar->nombre['val'] = $si['nombre'];


$indicador->indicador_id['val'] = $_POST['indicador_id'];
$tx->loadClass($indicador);
$si = $tx->returnObjectValues();
$indicador->nombre['val'] = $si['nombre'];

if($_POST['servicio_intrahospitalario_id']!='todos' && is_numeric($_POST['servicio_intrahospitalario_id']) ){
    $servh->servicio_intrahospitalario_id = $_POST['servicio_intrahospitalario_id'];
    $tx->loadClass($servh);
    $si = $tx->returnObjectValues();
    $servh->nombre['val'] = $si['nombre'];
    
}else{
    $servh->nombre['val'] = "Todos los servicios intrahospitalarios";
    
}

if($_POST['hospital_id']!='todos' && is_numeric($_POST['hospital_id']) ){
    MasterController::requerirModelo("hospital");
    $hospital = new hospital();
    $hospital->hospital_id['val'] = $_POST['hospital_id'];
    $trx = new ClassTransaction();
    $trx->loadClass($hospital);
    $hvalues = $trx->returnObjectValues();
    
    $hospital->nombre['val'] = htmlspecialchars($hvalues['nombre']); 
    $hospital->hospital_id['val'] = $hvalues['hospital_id'];
    
}else{
    $hospital->nombre['val'] = "Todos los hospitales";
    
}

?>
<div style="span10">
            

            <h1>Generaci&oacute;n de Reporte <small> [<?=$this->covertirAMes($finit->getMes()).", ".$finit->getAnio()?>] - [<?=$this->covertirAMes($fend->getMes()).", ".$fend->getAnio()?>] </small></h1>
			
            <div id="nuevoReporte" style="border: 1px solid #ccc; border-radius:4px; padding: 10px;">
                <a href="#" id="linkVerNuevoReporte">Nuevo reporte</a>
                <div id="nuevoReporteForm" style="display: none;">
                    <h3><small>Nuevo reporte</small></h3>
                <p>
                    Llene los campos que aparecen abajo para construir su reporte
                </p>
                <div id="mensajesDeAlerta"></div>
                <?php
                $alerts = $this->activesMsgs();
                if($alerts){ echo $alerts; }
                ?>

                <form  method="post" action="?v=reportes&action=visualizar" accept-charset="utf-8" class="form-horizontal" id="sendSubmitSubmision">
        <div class="control-group">
                        <label class="control-label"><span class="text-warning">*</span> Inicio:</label>
                        <div class="controls">
                            <select class="input-large" name="fecha_id_init" placeholder="fecha">
                                <?php 
									if( is_array( $fechas) ) {
										foreach($fechas AS $fec){
								?>
								
								<option value="<?=$fec['fecha_id']?>"><?=$this->monthName($fec['mes']) . " " . $fec['anio']?></option>
                                <?php
										}
									}
								?>
                            </select>
                        </div>            
                    </div>

                    <div class="control-group">
                        <label class="control-label"><span class="text-warning">*</span> Final:</label>
                        <div class="controls">
                            <select class="input-large" name="fecha_id_end" placeholder="fecha">
                                <?php 
									if( is_array( $fechas) ) {
										foreach($fechas AS $fec){
								?>
								
								<option value="<?=$fec['fecha_id']?>"><?=$this->monthName($fec['mes']) . " " . $fec['anio']?></option>
                                <?php
										}
									}
								?>
                            </select>
							
                        </div>
                    </div>
         <div class="control-group">
            <label class="control-label"><span class="text-warning">*</span> Estandar:</label>
            <div class="controls">
                <select name="estandar_id" class="input-xxlarge" id="select_estandar_combo_box">
                  <option class="input-xxlarge" selected="selected" value="0">Indique un Estandar</option>
                        <?

                         $mselect =  new MysqlSelect();
                         $mselect->setTableReference("estandar");
                         $mselect->addFilter("estandar", "estado", "1", "=");

                         if($mselect->execute()){
                            $grid = $mselect->rows;                    
                            foreach($grid AS $r){
                                ?><option value="<?=$r['estandar_id']?>"><?=$r['nombre']?></option><?
                            }

                        }

                         ?>
                </select>
            </div>            
        </div>
        <div class="control-group">
            <label class="control-label"><span class="text-warning">*</span> Indicador:</label>
            <div class="controls">
                <select name="indicador_id" class="input-xxlarge" id="select_indicador_combo_box">
                  <option class="input-xxlarge" selected="selected" value="0">Indique un Estandar</option>                        
                </select>
            </div>            
        </div>
        <div class="control-group">
            <label class="control-label"><span class="text-warning">*</span> Servicio Intra-Hospitalario:</label>
            <div class="controls">
                <select class="input-xxlarge" name="servicio_intrahospitalario_id" id="select_intrahosp_combo_box">
                    <option class="showFristSelect" value="0">elija antes un estandar</option>
                    
                </select>
            </div>            
        </div>
        
         <div class="control-group">
            <label class="control-label"><span class="text-warning">*</span> Hospital:</label>
            <div class="controls">
                <select class="input-xxlarge" name="hospital_id" id="select_hospital_combo_box">
                    <option selected="selected" value="todos">Todos los hospitales</option>
                        <?

                         $mselect =  new MysqlSelect();
                         $mselect->setTableReference("hospital");


                         if($mselect->execute()){
                            $grid = $mselect->rows;                    
                            foreach($grid AS $r){
                                ?><option value="<?=$r['hospital_id']?>"><?=$r['nombre']?></option><?
                            }

                        }

                         ?>
                </select>
            </div>            
        </div>
        <div id="formIndicadores"></div>
        
    
      
      <br />
      <button type="submit" class="btn">Ver reporte</button>
    </form>
                </div>
            </div>
            <div>
                <dl class="dl-horizontal">
                    <dt>Estandar aplicado</dt>
                    <dd><?=$estandar->nombre['val']?></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Indicador</dt>
                    <dd><?=$indicador->nombre['val']?></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Hospital</dt>
                    <dd><?=$hospital->nombre['val']?></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Servicio Intra-Hospitalario</dt>
                    <dd><?=$servh->nombre['val']?></dd>
                </dl>
            </div>


            <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <script type="text/javascript">
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
                /*var data = google.visualization.arrayToDataTable([
                  
                  <?php echo $this->grid; ?>
                ]);*/

                var dataPorcentajes = google.visualization.arrayToDataTable([
                  <?php echo $this->gridPorcentaje; ?>
                ]);

                /*var options = {
                  colors:['#1B55C0','#488C13',"#97080E","#E9B104"],  
                  title: 'Reporte por cantidades consolidadas',
                  hAxis: {title: 'Mes',  titleTextStyle: {color: 'red'}}
                };*/

                var optionsPorcentajes = {
                  colors:['#1B55C0','#488C13',"#97080E","#E9B104"],  
                  title: 'Reporte por representacion de Porcentajes (%)',
                  hAxis: {title: 'Mes',  titleTextStyle: {color: 'Black'}}
                };

                /*var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);*/

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_divPorcentajes'));
                chart.draw(dataPorcentajes, optionsPorcentajes);
              }

            </script>
            <div id="chart_divPorcentajes" style="width: 900px; height: 500px;"></div>
            <!--<div id="chart_div" style="width: 900px; height: 500px;"></div> -->
            
            <?php 
            //la cantidad de 
            $colsTabla = count($this->sqlRows);
            $filasTabla = count($this->sqlRows[0]) / 2;
            $descFila = Array();
            foreach($this->sqlRows[0] AS $rowName => $ValorRow){
                if(!is_numeric($rowName )){
                    $descFila[] = $rowName;
                }

            }

            ?>
            <!--
            <div style="span9">
                <h3>Fuente de datos cantidades absolutas</h3>
                <table class="table">
                    <thead>
                        <tr>

                        <th><?=$descFila[0]?></th>
                        <?php for($i = 0; $i< $colsTabla; $i++){
                            ?> <th><?= $this->covertirAMes($this->sqlRows[$i]['mes']) . ", ".$this->sqlRows[$i]['anio']?></th> <?php
                        }    
                        ?>
                        <th>Totales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($j=1;$j<$filasTabla;$j++){
                        	if($descFila[$j] != 'ingresos'){
                            ?><tr>
                            <td>Total <?=$descFila[$j]?></td>
                            <?php
                            $c = 0;
                            for($k = 0; $k< $colsTabla; $k++){
                                ?> <td><?=$this->sqlRows[$k][$j]?> </td> <?php
                              $c +=  $this->sqlRows[$k][$j];
                            }
                            ?><td><?php echo $c;?></td><?php
                            ?></tr><?php }
                        }
                        ?>
                    </tbody>


                </table>
                
            </div>
            -->
            
            <div style="span9">
                <h3>Fuente de datos porcentajes</h3>
                <table class="table">
                    <thead>
                        <tr>

                        <th><?=ucfirst($descFila[0])?></th>
                        <?php for($i = 0; $i< $colsTabla; $i++){
                            ?> <th><?= $this->covertirAMes($this->sqlRows[$i]['mes'])?></th> <?php
                        }    
                        ?>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($j=1;$j<$filasTabla;$j++){
                        	if($descFila[$j] != 'ingresos'){
                            ?><tr>
                                <td>Total <?= ucfirst( $descFila[$j])?></td>
                            <?php
                            $c = 0;
                            for($k = 0; $k< $colsTabla; $k++){
                                ?> <td><!-- <?=$this->sqlRows[$k][2]?> -- <?=$this->sqlRows[$k][$j]?>--> 
                                    <? $this->sqlRows[$k][1]?>  <? echo round(($this->sqlRows[$k][$j] * 100/ $this->sqlRows[$k][2]),2 ); ?>%</td> <?php
                              $c +=  $this->sqlRows[$k][$j];
                            }
                            ?></tr><?php }
                        }
                        ?>
                    </tbody>


                </table>
                
            </div>
        
       




</div>
<style>
	table.table tbody tr:first-child {
		display: none;
	}
	
</style>
