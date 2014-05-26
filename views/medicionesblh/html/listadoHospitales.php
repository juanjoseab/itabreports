<?php
if ($this->acl->acl("Submision")) {
    MasterController::requerirModelo("hospital");
    $hospital = new hospital();
    $hospitales = $hospital->getList(Array(), array());
    ?>




    <div class="span9" id="TopForm">

        <h1>Información básica <small>para bancos de leche humana</small></h1>
        <p>
            Seleccione el hospital.
        </p>
        <div id="mensajesDeAlerta"></div>
        <?php
        $alerts = $this->activesMsgs();
        if ($alerts) {
            echo $alerts;
        }
        ?>

    </div>



    <div class="span4">
        <select size="20" name="hospital_id"  id="hospitalCombo" style="width: 375px;">
            <?php
            foreach ($hospitales AS $h) {
                ?> <option value="<?= $h['hospital_id'] ?>"><?= $h['nombre'] ?></option> <?php
            }
            ?>
        </select>    

    </div>
    <div class="span4" id="formLoaderBox">


    </div>











    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Respuesta</h3>
        </div>
        <div class="modal-body" id="modalBodyP">

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>            
        </div>
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
<link href="template/css/jqui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">

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
    .ui-datepicker {
        font-size: 12px;
    }

    #formLoaderBox {
        min-height: 300px;
    }

    #formLoaderBox.loading {
        background: url(template/img/loading.gif) no-repeat center center;
    }

</style>

<script>
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

        function bind_datepicker_to_date_fields()
        {
            $.datepicker.setDefaults($.datepicker.regional['es']);
            $("input.datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-m-d",
                yearRange: '-125:+0'
            });
        }

   


        var xhl = false;
        $("#hospitalCombo").change(function() {
            if (xhl) {
                xhl.abort();
            }
            
            $("#formLoaderBox *").remove();
            $("#formLoaderBox").addClass("loading");
            var hospitalID = $(this).val();
            xhl = $.ajax({
                url: '?v=medicionesblh&action=formInfoBasica&hid=' + hospitalID,
                type: 'GET',
                data: "",
                success: function(res) {
                    
                    $("#formLoaderBox").removeClass("loading");
                    $("#formLoaderBox").append(res);
                    bind_datepicker_to_date_fields();
                }
            })
        });


        $("#myModal").modal("hide");
        $("body").on("click", "#sbmt", function() {
            var values = $("form#infoBasica").serialize();
            $.ajax({
                url: '?v=medicionesblh&action=submitBasicInfo',
                type: 'POST',
                data: values,
                success: function(res) {
                    $("#modalBodyP *").remove();
                    $("#modalBodyP").append(res);
                    $("#myModal").modal("show");
                    //$('form#infoBasica input[type="text"]').val("");

                    //alert(res);
                }
            })
        });

        $(".sbmttest").click(function() {
            var values = $("form#infoBasica").serialize();

            $.ajax({
                url: '?v=medicionesblh&action=submitBasicInfoTEST',
                type: 'POST',
                data: values,
                success: function(res) {
                    $("#modalBodyP *").remove();
                    $("#modalBodyP").append(res);
                    $("#myModal").modal("show");
                    $('form#infoBasica input[type="text"]').val("");

                    //alert(res);
                }
            })
        });

    })
</script>

<script type="text/javascript" src="template/js/jquery-ui-1.10.3.custom.min.js"></script>
<script type = "text/javascript">
    $(function() {








    });
</script>


