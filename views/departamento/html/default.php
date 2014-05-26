<script type="text/javascript" lang="JavaScript">
    $(function() {

        $('#myModal').modal();
        $('#myModal').modal('hide');
        $("a.doOpenModal").click(function() {
            $("#myModal input#departamentoIdToSubmit").val("");
            $("#myModal input#departamentoNombre").val("");
            var itemId = $(this).attr("relid");
            $('#myModal').modal('show');
            $("#myModal input#departamentoIdToSubmit").val(itemId);
            var itemVal = "";
            $.ajax({
                url: "?v=departamento&action=getDepartamentoById&itemId=" + itemId,
                type: "GET",
                data: "",
                success: function(res) {
                    if (res.length > 0) {
                        itemVal = res;
                    } else {
                        itemVal = "Objeto no encontrado";
                    }
                    $("#myModal input#departamentoNombre").val(res);
                }
            });



        });




        $("#sendSumbit").click(function() {

            $("#myModal .modal-body").addClass("customLoading");
            //alert();
            $("form#addMunicipioForm > div, button#sendSumbit").slideUp();
            var datos = $("form#addMunicipioForm").serialize();
            $.ajax({
                url: "?v=departamento&action=addMunicipio",
                data: datos,
                type: "POST",
                success: function(res) {
                    $("form#addMunicipioForm").prepend(res);
                    $("#myModal .modal-body").removeClass("customLoading");
                    $("form#addMunicipioForm input#Nombre").val("");
                    $("form#addMunicipioForm input#Codigo").val("");
                    $("#addOther").show();
                }
            })



            return false;
        })

        $("#addOther").click(function() {
            $(".alert").remove();
            $("form#addMunicipioForm > div, button#sendSumbit").show();
            $(this).hide();
        });


    });
</script>
<div class="span9">
    <h1>Departamentos</h1>
    <? $this->createDepartamentoGrid(false); ?>

    <?php
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>
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
                    <td><?= $r['departamento_id'] ?></td>
                    <td><?= $r['nombre'] ?></td>
                    <td>
                        <? if ($r['estado'] == 1) { ?>
                            <span class="btn btn-success">Activo</span>
        <? } else { ?>
                            <span class="btn btn-danger">Inactivo</span>
        <? } ?>

                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                Opciones
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">

                                <? if ($this->acl->acl("Agregar")) { ?>
                                    <li><a class="doOpenModal" href="?v=departamento" relid="<?= $r['departamento_id'] ?>" data-toggle="modal" data-target="#modal">Agregar Municipio</a></li>
                                <? } ?> 

                                <? if ($this->acl->acl("Modificar")) { ?>
                                    <li><a class="needAlertConfirm" href="?v=departamento&action=viewUpdateForm&itemId=<?= $r['departamento_id'] ?>">Editar</a></li>
                                <? } ?>

                                <? if ($this->acl->acl("Desactivar")) { ?>
                                    <li><a class="needAlertConfirm" href="#">Desactivar</a></li>
                                <? } ?>  

        <? if ($this->acl->acl("Eliminar")) { ?>
                                    <li><a class="needAlertConfirm" href="?v=departamento&action=delete&itemId=<?= $r['departamento_id'] ?>">Eliminar</a></li>
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
            } ?>><a href="<?php echo $this->returnThisUrl(); ?>&pag=<?= $pag ?>"><?= ($pag + 1) ?></a></li>
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
        <h3 id="myModalLabel">Agregar Municipio</h3>
    </div>
    <div class="modal-body">

        <form class="form-horizontal" action="?v=departamento&action=addMunicipio" accept-charset="utf-8"  method="post" id="addMunicipioForm">

            <div class="control-group">


                <label class="control-label">Nombre del Municipio</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="Nombre" name="nombre" />
                </div>

                <label class="control-label">C&oacute;digo</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="Codigo" name="codigo" />
                </div>
                <label class="control-label">Departamento</label>
                <div class="controls">
                    <input type="text" readonly="readonly" class="input-xlarge uneditable-input" id="departamentoNombre" name="departamentoNombre" />
                    <input type="hidden" readonly="readonly" class="input-small uneditable-input" id="departamentoIdToSubmit" name="departamento_id" />
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
