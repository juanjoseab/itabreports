<?php
MasterController::requerirModelo("fecha");
$fecha = new fecha();

$fechas = $fecha->getList(array(), array());
?>

<div class="span9">

    <h1>Reportes de mediciones<br/><small>Bancos de Leche Humana</small></h1>
    <p>

    </p>
    <div id="mensajesDeAlerta"></div>
    <?php
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>


    <ul class="nav nav-tabs nav-pills" id="myTab">
        <li class="active"><a href="#home">Reporte General</a></li>
        <li><a href="#profile">Gráfica</a></li>

    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home">

            <h2>Reporte general de mediciones</h2>

            <form  
                method="post" 
                action="?v=reportesblh&action=reporteGeneral" 
                class="form-horizontal" 
                id="medicionBlhReportForm">
                <fieldset>
                    <legend>Selección de variables</legend>

                    <div class="control-group">
                        <label class="control-label"><span class="text-warning"></span> Información básica</label>
                        <div class="controls">
                            <input type="checkbox" name="infobasica" value="si" />                           
                        </div>            
                    </div>

                    <div class="control-group">
                        <label class="control-label">Variables de producción</label>
                        <div class="controls">                            
                            <input type="checkbox" name="produccion" value="si" />                            
                        </div>            
                    </div>
                    <div class="control-group">
                        <label class="control-label">Variables de calidad</label>
                        <div class="controls">
                            <input type="checkbox" name="calidad" value="si" />
                        </div>            
                    </div>

                    <div class="control-group">
                        <label class="control-label">Variables de funcionamiento mensual</label>
                        <div class="controls">
                            <input type="checkbox" name="func-anio" value="si" />
                        </div>            
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">Variables de funcionamiento anual</label>
                        <div class="controls">
                            <input type="checkbox" name="func-mes" value="si" />
                        </div>            
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Selección de fechas</legend>

                    <div class="control-group">
                        <label class="control-label">Fecha inicial:</label>
                        <div class="controls">
                            <input type="text" class="input-large datepicker" name="fechainicio" />                        
                        </div>            
                    </div>

                    <div class="control-group">
                        <label class="control-label">Fecha final:</label>
                        <div class="controls">
                            <input type="text" class="input-large datepicker" name="fechafin" />
                        </div>            
                    </div>
                </fieldset>

                <div class="control-group">
                    <div class="controls">
                        <button type="button" id="repGeneral" class="btn">Ver reporte</button>
                    </div>            
                </div>



            </form>


            

        </div>
        <div class="tab-pane" id="profile">
            <h2><i class="icon icon-info-sign"></i> Reporte en construcción</h2>

        </div>

    </div>



</div>


	<div id="formGeneralReportResponse">            	
          	
    </div>

<script type="text/javascript" src="template/js/jquery-ui-1.10.3.custom.min.js"></script>
<link href="template/css/jqui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">

<script type="text/javascript" lang="JavaScript">
    $(function() {
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $("input.datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-m-d",
            yearRange: '-125:+0'
        });

        $('#myTab a:first').tab('show');

        $('#myTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        })

        $("#repGeneral").click(function() {
        	var values = $("form#medicionBlhReportForm").serialize();
            $("#formGeneralReportResponse *").remove();
            $.ajax({
                url: '?v=reportesblh&action=getProductionTable',
                type: 'POST',
                data: values,
                success: function(res) {
                    $("#formGeneralReportResponse").append(res);
                }
            });
        })


        $("select#select_estandar_combo_box").change(function() {
            $("select#select_intrahosp_combo_box option").remove();
            $.ajax({
                url: '?v=reportes&action=returnOptions&referencia=servicios&itemId=' + $(this).val(),
                type: 'GET',
                data: '',
                success: function(res) {
                    $("select#select_intrahosp_combo_box").append(res);
                }
            });

            $.ajax({
                url: '?v=reportes&action=returnOptions&referencia=indicadores&itemId=' + $(this).val(),
                type: 'GET',
                data: '',
                success: function(res) {
                    $("select#select_indicador_combo_box option").remove();
                    $("select#select_indicador_combo_box").append(res);
                }
            });
        })


    });
</script>

<style>
    #myTab {
        border:0;
    }

    .ui-datepicker {
        font-size: 12px;
    }

</style>


