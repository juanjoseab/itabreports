<?php
if($this->acl->acl("Modificar")){
    MasterController::requerirModelo("fecha");
    $item = new fecha();
    $item->setFechaId($_GET['itemId']);
    $item->getValuesBySetedId();
    
    

?>
<div class="span9">
    
    <h3>Editar estandar</h3>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong> y <strong>Estado</strong> son obligatorios</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=fechas&action=update">
        <input type="hidden" name="fecha_id" value="<?=$item->getFechaId()?>" />
            <label><span class="text-warning">*</span> A&ntilde;o:</label>
            <select name="anio">
                <?php
                for ($y = $item->getAnio() - 2; $y < date('Y')+10; $y++){
                    ?>
                <option <?=($item->getAnio()==$y)?'selected="selected"':''?> value="<?=$y?>"><?=$y?></option>
                        <?php
                }
                ?>
            </select>

            <label><span class="text-warning">*</span> Mes:</label>
            <select name="mes">
                <?php
                for ($m = 1; $m <= 12; $m++){
                    ?>
                <option <?=($item->getMes()==$m)?'selected="selected"':''?> value="<?=$m?>"><?=$this->monthName($m)?></option>
                        <?php
                }
                ?>
            </select>

              
            <label><span class="text-warning">*</span> Estado:</label>
            <select name="estado">
                <option <?=($item->getEstado()==1)?'selected="selected"':''?> value="1">Activa</option>
                <option <?=($item->getEstado()==0)?'selected="selected"':''?>value="0">Inactiva</option>
            </select><br />
            <button type="submit" class="btn">Guardar</button>
        </form>

</div>

<? }else{ ?>
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


