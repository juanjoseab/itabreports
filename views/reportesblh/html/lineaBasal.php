<?php
MasterController::requerirModelo("fecha");
MasterController::requerirModelo("estandar");
$estandar = new estandar();
$fecha = new fecha();

$estandares = $estandar->getList(array(), array());
$fechas = $fecha->getList(array(), array());
?>
<div class="span9">
    <h2>Reporte de comparación de mediciones de indicadores</h2>

    <div class="filtersPanel">
        <form id="lineaBasalForm" action="?v=reportes&action=generateLineaBasalTableToExcel" method="POST" action="" class="form-horizontal">
            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> Inicio:</label>
                <div class="controls">
                    <select class="input-large" name="fecha_id" placeholder="fecha">
                        <?php
                        if (is_array($fechas)) {
                            foreach ($fechas AS $fec) {
                                ?>

                                <option value="<?= $fec['fecha_id'] ?>"><?= $this->monthName($fec['mes']) . " " . $fec['anio'] ?></option>
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
                    <select class="input-xxlarge" id="estandar_id" name="estandar_id" placeholder="estandar">
                        <option value="null">Estandares</option>
                        <?php
                        if (is_array($estandares)) {
                            foreach ($estandares AS $estand) {
                                ?>

                                <option value="<?= $estand['estandar_id'] ?>"><?= $estand["nombre"] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>            
            </div>


            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> Indicador:</label>
                <div class="controls">
                    <select class="input-xxlarge" id="indicador_id" name="indicador_id" placeholder="indicador">
                        <option value="null">Elija un estandar primero</option>
                    </select>
                </div>            
            </div>

            <button type="button" id="btnGenerate" class="btn">Generar reporte</button>
            <button type="button" id="btnGenerateToExcel" class="btn">Generar reporte a excel</button>

        </form>
    </div>

    <div id="reportBox">

    </div>


</div>

<script type="text/javascript">
    $(function() {

        $("#estandar_id").change(function() {
            if ($(this).val() == "null") {
                $("select#indicador_id option").remove();
                return false;
            }

            $.ajax({
                url: '?v=reportes&action=returnOptions&referencia=indicadoresNotAll&itemId=' + $(this).val(),
                type: 'GET',
                data: '',
                success: function(res) {
                    $("select#indicador_id option").remove();
                    $("select#indicador_id").append(res);
                }
            });
        });
        
        $("#btnGenerate").click(function(){
            var valores = $("form#lineaBasalForm").serialize();
            $.ajax({
                url: '?v=reportes&action=generateLineaBasalTable',
                type: 'POST',
                data: valores,
                success: function(res) {
                    $("#reportBox *").remove();
                    $("#reportBox").append(res);
                }
            });
        })
        
        $("#btnGenerateToExcel").click(function(){
            $("form#lineaBasalForm").submit();
           
        })

    });


</script>