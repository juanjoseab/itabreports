<script type="text/javascript" lang="JavaScript">
    $(function() {

        $('#myModal').modal();
        $('#myModal').modal('hide');
        $("div#filtros_tabla").hide();
        $("#verfiltros").click(function() {
            $("div#filtros_tabla").toggle();
        })



        $("a.doOpenModal").click(function() {
            $("#myModal input#departamentoIdToSubmit").val("");
            $("#myModal input#departamentoNombre").val("");
            var relid = $(this).attr("relid");
            var relname = $(this).attr("relname");


            $('#myModal').modal('show');
            $("#myModal input#dasId").val(relid);
            $("#myModal input#dasNombre").val(relname);






        });




        $("#sendSumbit").click(function() {

            $("#myModal .modal-body").addClass("customLoading");
            //alert();
            $("form#addChildForm > div, button#sendSumbit").slideUp();
            var datos = $("form#addChildForm").serialize();
            $.ajax({
                url: "?v=das&action=addChild",
                data: datos,
                type: "POST",
                success: function(res) {
                    $("form#addChildForm").prepend(res);
                    $("#myModal .modal-body").removeClass("customLoading");
                    $("form#addChildForm input#Nombre").val("");
                    $("#addOther").show();
                }
            })



            return false;
        })

        $("#addOther").click(function() {
            $(".alert").remove();
            $("form#addChildForm > div, button#sendSumbit").show();
            $(this).hide();
        });



        $("select#select_departamento_combo_box").change(function() {
            $("select#select_municipio_combo_box option").remove();
            $.ajax({
                url: '?v=das&action=returnOptions&referencia=municipios&itemId=' + $(this).val(),
                type: 'GET',
                data: '',
                success: function(res) {
                    $("select#select_municipio_combo_box").append(res);
                }
            });
        })


    });
</script>
<div class="span9">
    <h3>Listado de Estandares</h3>

    <?php
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>


<? $this->createGrid(false); ?>
    <div class="span9">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>


            <?
            if (count($this->grid) > 0) {
                foreach ($this->grid AS $row => $r) {
                    ?>
                    <tr>
                        <td><?= $r['estandar_id'] ?></td>
                        <td><?= $r['nombre'] ?></td>
                        <td>
                            <? if ($r['estado'] == 1) { ?>
                                <span class="btn btn-success">Activa</span>
        <? } else { ?>
                                <span class="btn btn-danger">Inactiva</span>
        <? } ?>

                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    Opciones
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">



        <? if ($this->acl->acl("Modificar")) { ?>
                                        <li><a href="?v=estandares&action=viewUpdateEstandarForm&itemId=<?= $r['estandar_id'] ?>">Editar</a></li>
        <? } ?>

                                    <li><a href="?v=estandares&action=viewDetails&itemId=<?= $r['estandar_id'] ?>">Ver detalles</a></li>


        <? if ($this->acl->acl("Eliminar")) { ?>
                                        <li><a class="needAlertConfirm" href="?v=estandares&action=delete&itemId=<?= $r['estandar_id'] ?>">Eliminar</a></li>
        <? } ?>

                                </ul>
                            </div>

                        </td>
                    </tr>
                <?
            }
        }
        ?>
        </table>
        <?
        $pags = $this->getArrayPaginacion();
        if ($_GET['pag'] == 0 || !$_GET['pag']) {
            $pageActive = 0;
        } else {
            $pageActive = $_GET['pag'];
        }
        ?> 
        <div class="pagination">
            <ul>
                <?php
                if (count($pags) == 1) {
                    ?>
                    <li class="active"><a href="#">1</a></li>
                    <?
                } else {
                    foreach ($pags as $pag) {
                        ?>
                        <li <?php if ($pag == $pageActive) {
                    echo 'class="active"';
                } ?>><a href="?v=das&pag=<?= $pag ?>"><?= ($pag + 1) ?></a></li>
        <?
    }
}
?>
            </ul>
        </div>


    </div>

    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Agregar distrito de salud</h3>
        </div>
        <div class="modal-body">

            <form class="form-horizontal" action="?v=das&action=addChild" accept-charset="utf-8" method="post" id="addChildForm">

                <div class="control-group">
                    <label class="control-label">&Aacute;rea de salud</label>
                    <div class="controls">
                        <input type="text" readonly="readonly" class="input-xlarge" id="dasNombre" name="dasNombre" />
                        <input type="hidden" class="input-xlarge" id="dasId" name="area_salud_id" />
                    </div>
                    <label class="control-label">Nombre del distrito</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge" id="Nombre" name="nombre" />
                    </div>
                    <label class="control-label">Departamento</label>
                    <div class="controls">
                        <select name="departamento_id" id="select_departamento_combo_box">
                            <option value="0">Elija un departamento</option>
                            <?
                            MasterController::requerirClase("MysqlSelect");
                            $mselect = new MysqlSelect();
                            $mselect->setTableReference("departamento");
                            $mselect->addFilter("departamento", "estado", "1", "=");

                            if ($mselect->execute()) {
                                $grid = $mselect->rows;
                                foreach ($grid AS $dep) {
                                    ?><option value="<?= $dep['departamento_id'] ?>"><?= $dep['nombre'] ?></option><?
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <label class="control-label">Municipio</label>
                    <div class="controls">
                        <select name="municipio_id" id="select_municipio_combo_box" >

                        </select>
                    </div>            

                    <label class="control-label">Estado</label>
                    <div class="controls">
                        <select name="estado">
                            <option selected="selected" value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>




                </div>

            </form>
            <button type="button" class="btn btn-info" id="addOther" style="display: none;">Agregar Otro</button>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
            <button class="btn btn-primary" id="sendSumbit">Guardar</button>

        </div>
    </div>
</div>
