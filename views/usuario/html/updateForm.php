<?php
if ($this->acl->acl("Administrar Usuarios")) {
    MasterController::requerirClase("MysqlSelect");
    MasterController::requerirModelo("usuario");
    $item = new usuario();
    $item->usuario_id['val'] = $_GET['itemId'];
    $tx = new ClassTransaction();
    $tx->loadClass($item);
    $values = $tx->returnObjectValues();
    $item->nombre['val'] = $values['nombre'];
    $item->login['val'] = $values['login'];
    $item->clave['val'] = $values['clave'];
    $item->rol_id['val'] = $values['rol_id'];
    ?>
    <script type="text/javascript" language="JavaScript">
        $(function() {
            $("input#Reclave").keyup(function() {
                var thisval = $(this).val();
                var clave = $("input#Clave").val();
                //alert("ingresado :" + thisval + " - Clave: "+ clave);
                if (thisval == clave) {
                    $(this).css("border-color", "#00FF00");
                } else {
                    $(this).css("border-color", "#FF0000");
                }
                activarEnviar();
            })


            function activarEnviar() {
                if (($("input#Reclave").val() == $("input#Clave").val())) {
                    $("#submitButton").removeAttr("disabled");
                    return true;
                } else {
                    $("#submitButton").attr("disabled", "disabled");
                    return false;
                }
            }

            $("form#insertUserForm").submit(function() {
                if (activarEnviar()) {
                    return true;
                } else {
                    alert('por favor verifique algun error en el formulario, ');
                    return false;
                }
            })
        });
    </script>
    <div class="span9">
        <h3>Editar usuario</h3>
        <p>
            Modifique los campos que aparecen abajo, para mantener la misma contrase&ntilde;a <span class="label label-info">deje en blanco los campos de Clave y reingreso de clave</span>
        </p>

        <?php
        $alerts = $this->activesMsgs();
        if ($alerts) {
            echo $alerts;
        }
        ?>

        <form  method="post" action="?v=usuario&action=updateUser" accept-charset="utf-8" id="insertUserForm">
            <div class="control-group">
                <label class="control-label">Nombre:</label>
                <input type="text" class="input-xlarge" id="Nombre" name="nombre" value="<?= $item->nombre['val'] ?>" />
                <input type="hidden" name="usuario_id" value="<?= $item->usuario_id['val'] ?>"/>
                <label class="control-label">Login de acceso: </label>
                <input type="text" class="input-xlarge" errFlag="vacio" id="Login" name="login" value="<?= $item->login['val'] ?>" readonly="readonly"/>

                <label class="control-label">Clave:</label>
                <input type="password" class="input-xlarge" id="Clave" name="clave" autocomplete="off"/>

                <label class="control-label">Reingrese la clave:</label>
                <input type="password" class="input-xlarge" id="Reclave" name="reclave" autocomplete="off"/>

                <label class="control-label">Rol a asingar:</label>
                <div class="controls">
                    <select name="rol_id" id="select_rol_combo_box">

                        <?
                        $mselect = new MysqlSelect();
                        $mselect->setTableReference("rol");


                        if ($mselect->execute()) {
                            $grid = $mselect->rows;
                            foreach ($grid AS $r) {
                                ?><option <?php if ($r['rol_id'] == $item->rol_id['val']) {
                        echo 'selected="selected"';
                    } ?>value="<?= $r['rol_id'] ?>"><?= $r['nombre'] ?></option><?
                            }
                        }
                        ?>
                    </select>

                </div>
                <div class="control-group">
                    <div class="controls">

                        <button type="submit" id="submitButton" class="btn">Guardar</button>
                    </div>
                </div>


            </div>
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

