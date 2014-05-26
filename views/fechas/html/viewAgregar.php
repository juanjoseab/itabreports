<?php
if ($this->acl->acl("Agregar")) {
    ?>
    <div class="span9">

        <h2>Agregar Fecha <small>para ingreso de datos</small> </h2>
        <p>
            Llene los campos que aparecen abajo, <span class="label label-important">Todos los campos son obligatorios</span>
        </p>
    <?php
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>

        <form  method="post" action="?v=fechas&action=insert">
            <label><span class="text-warning">*</span> A&ntilde;o:</label>
            <select name="anio">
                <?php
                for ($y = date('Y') - 2; $y < date('Y')+5; $y++){
                    ?>
                <option value="<?=$y?>"><?=$y?></option>
                        <?php
                }
                ?>
            </select>

            <label><span class="text-warning">*</span> Mes:</label>
            <select name="mes">
                <?php
                for ($m = 1; $m <= 12; $m++){
                    ?>
                <option value="<?=$m?>"><?=$this->monthName($m)?></option>
                        <?php
                }
                ?>
            </select>

              
            <label><span class="text-warning">*</span> Estado:</label>
            <select name="estado">
                <option selected="selected" value="1">Activa</option>
                <option value="0">Inactiva</option>
            </select><br />
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


