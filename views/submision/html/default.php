<?php
if ($this->acl->acl("Submision")) {
    MasterController::requerirModelo("fecha");
    $insertDate = new fecha();
    ?>


    <script type="text/javascript" lang="JavaScript">
        $(function() {

            function getSubmisions() {
                if (
                        $("select#select_hospital_combo_box").val() > 0
                        && $("select#select_estandar_combo_box").val() > 0
                        && $("select#asignacionFecha").val() > 0
                        ) {
                    var idH = $("select#select_hospital_combo_box").val();
                    var idE = $("select#select_estandar_combo_box").val();
                    var idF = $("select#asignacionFecha").val();
                    var Uri = "&idh=" + idH
                            + "&ide=" + idE
                            + "&idf=" + idF;

                    $.ajax({
                        url: '?v=submision&action=returnOptions&referencia=submisiones' + Uri,
                        type: 'GET',
                        data: '',
                        success: function(res) {

                            var json = $.parseJSON(res);
                            $("div#headerFormIndicadores h2").remove();
                            $("div#headerFormIndicadores blockquote").remove();
                            $("<h2>Ingreso # " + (json.counter + 1) + "</h2>")
                                    .appendTo("div#headerFormIndicadores");
                            $("<blockquote>Actualmente se han ingresado " + json.counter + " registros de este estandar para este hospital en dicha fecha<br />"
                                    + "<b>Estandar</b>: " + $("select#select_estandar_combo_box option[value='" + idE + "']").text() + "<br />"
                                    + "<b>Hostpital</b>: " + $("select#select_hospital_combo_box option[value='" + idH + "']").text() + "<br />"
                                    + "<b>Fecha</b>: " + $("select#asignacionFecha option[value='" + idF + "']").text() + "<br />"
                                    + "</blockquote>")
                                    .appendTo("div#headerFormIndicadores");




                            //console.log(res);
                            $.hideLoader();
                            //return true;

                        }
                    });
                }
                return true;
            }

            $("select#select_departamaento_combo_box").change(function() {
                $("select#select_hospital_combo_box option").remove();
                $.showLoader();
                $.ajax({
                    url: '?v=submision&action=returnOptions&referencia=hospitales&itemId=' + $(this).val(),
                    type: 'GET',
                    data: '',
                    success: function(res) {
                        $("select#select_hospital_combo_box").append(res);
                        $.hideLoader();
                    }
                });

            })


            $("select#select_estandar_combo_box").change(function() {
                $.showLoader();
                $("select#select_intrahosp_combo_box option").remove();                
                $("div#formIndicadores div").remove();
                $.ajax({
                    url: '?v=submision&action=returnOptions&referencia=servicios&itemId=' + $(this).val(),
                    type: 'GET',
                    data: '',
                    success: function(res) {
                        $("select#select_intrahosp_combo_box").append(res);
                    }
                });

                $.ajax({
                    url: '?v=submision&action=returnOptions&referencia=indicadores&itemId=' + $(this).val(),
                    type: 'GET',
                    data: '',
                    success: function(res) {
                        
                        $("div#formIndicadores").append(res);

                    }
                });
                getSubmisions();
            })

            $("form#sendSubmitSubmision").submit(function() {
                $.showLoader();
                var values = $(this).serialize();
                $.ajax({
                    url: '?v=submision&action=doSubmission',
                    type: 'POST',
                    data: values,
                    success: function(res) {
                        $("div#mensajesDeAlerta .alert").remove();
                        $("div#mensajesDeAlerta").append(res);
                        $('body,html').animate({scrollTop: 0}, 800);
                        getSubmisions();
                        //hideLoader();
                        return false;
                    }
                });
                //hideLoader();
                return false;
            });

            

        });
    </script>

    <div class="span9" id="TopForm">

        <h1>Registro de datos <small>Encuesta a un estandar</small></h1>
        <p>
            Llene los campos que aparecen abajo, <span class="label label-important">Todos son obligatorios</span>.
        </p>
        <div id="mensajesDeAlerta"></div>
        <?php
        $alerts = $this->activesMsgs();
        if ($alerts) {
            echo $alerts;
        }
        ?>

        <form  method="post" action="?v=submision&action=doSubmission" accept-charset="utf-8" class="form-horizontal" id="sendSubmitSubmision">
            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> Nombre del personal:</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="nombre_personal" placeholder="Nombre del personal que realizo la encuesta" />
                </div>            
            </div>

            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> Cargo:</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="cargo" placeholder="Cargo del personal que realizo la encuesta" />
                </div>            
            </div>

            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> No. de Historia cl&iacute;nica del paciente:</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="historia_clinica" placeholder="No. de Historial clinico del paciente encuestado" />
                </div>            
            </div>


            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> Asignación de fecha:</label>
                <div class="controls">
                    <select class="input-xxlarge" name="date" placeholder="fecha de asignación para la captura de los datos" id="asignacionFecha">
                        <?php
                        $fechasActivas = $insertDate->getList(array("fecha_id", "mes", "anio"), array("estado" => array("1", "=")));
                        if (count($fechasActivas) > 0) {
                            foreach ($fechasActivas AS $fi) {
                                ?>
                                <option value="<?= $fi['fecha_id'] ?>"><?= $this->monthName($fi['mes']) . ", " . $fi['anio'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>            
            </div>

            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> Departamento:</label>
                <div class="controls">
                    <select name="departamento_id" class="input-xxlarge" id="select_departamaento_combo_box">
                        <option selected="selected" value="0">Indique un departamento</option>
                        <?
                        $mselect = new MysqlSelect();
                        $mselect->setTableReference("departamento");
                        $mselect->addFilter("departamento", "estado", 1, "=");


                        if ($mselect->execute()) {
                            $grid = $mselect->rows;
                            foreach ($grid AS $r) {
                                ?><option value="<?= $r['departamento_id'] ?>"><?= $r['nombre'] ?></option><?
                            }
                        }
                        ?>
                    </select>
                </div>            
            </div>

            <div class="control-group">
                <label class="control-label"><span class="text-warning">*</span> Hospital:</label>
                <div class="controls">
                    <select class="input-xxlarge" name="hospital_id" id="select_hospital_combo_box">

                        <?
                        $mselect = new MysqlSelect();
                        $mselect->setTableReference("hospital");


                        if ($mselect->execute()) {
                            $grid = $mselect->rows;
                            foreach ($grid AS $r) {
                                ?><option value="<?= $r['hospital_id'] ?>"><?= $r['nombre'] ?></option><?
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
                        $mselect = new MysqlSelect();
                        $mselect->setTableReference("estandar");
                        $mselect->addFilter("estandar", "estado", "1", "=");

                        if ($mselect->execute()) {
                            $grid = $mselect->rows;
                            foreach ($grid AS $r) {
                                ?><option value="<?= $r['estandar_id'] ?>"><?= $r['nombre'] ?></option><?
                            }
                        }
                        ?>
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





            <div id="headerFormIndicadores">

            </div>
            <div id="formIndicadores"></div>



            <br />
            <button type="submit" class="btn">Agregar</button>
        </form>

    </div>

<? } else { ?>
    <div class="span6">
        <div class="alert alert-block">

            <h4>Acceso no permitido!</h4>
            No tiene suficientes privilegios en el sistema para poder agregar datos.
        </div>
    </div>


<?php } ?>

<?php
/*
  $this->loadContentView("default");
  $this->getContentView();
 */
?>

<style>
    .preloaderContainer {
        width: 200px;
        height: 200px;
        background: url(template/img/loadingbg.png) no-repeat center center;
        position: absolute;

    }

    .preloaderBox {
        width: 200px;
        height: 200px;
        background: url(template/img/loading.gif) no-repeat center center;
    }

</style>