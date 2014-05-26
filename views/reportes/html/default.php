<?php
MasterController::requerirModelo("fecha");
$fecha = new fecha();

$fechas = $fecha->getList(array(),array());

?>

<script type="text/javascript" lang="JavaScript">
    $(function(){
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
        
        
    });
</script>
    
    


<div class="span9">
    
    <h1>Reportes</h1>
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