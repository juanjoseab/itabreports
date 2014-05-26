<?php
MasterController::requerirModelo("module");
$mod = new module();
$mod->setIdModule($_GET['mid']);
$mod->getValuesBySetedId();

if ($mod->getName()) {
    ?>

    <form 
        role="form" 
        accept-charset="utf-8" 
        class="form-horizontal" 
        id="crearModule" 
        method="POST" 
        action="?v=modules&action=deleteModule">
        <fieldset>
            <legend>Confirmar la acción</legend>
            <h3 class="text-danger">¿Realmente quieres eliminar el modulo <?= $mod->getName() ?> ?</h3>
            <input type="hidden" name="id_module" value="<?= $mod->getIdModule() ?>" />
            <div class="form-group">
                <div class="controls">
                    <button type="submit" class=" btn btn-danger ">Proceder a eliminar</button>
                    <a href="?v=modules" class="btn btn-success">Cancelar</a>
                </div>
            </div>
        </fieldset>

    </form>
<?php } else { ?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>¡Ocurrio un error!</strong> El módulo indicado no existe.
    </div>
<?php } ?>