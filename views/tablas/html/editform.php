<?php
MasterController::requerirModelo("module");
$item = new module();
$mod = new module();
$modList = $mod->getList(array(), array("id_parent" => array("1", "IS NULL AND '1' = ")));
$item->setIdModule($_GET['mid']);
$item->getValuesBySetedId();
if ($item->getName()) {

    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>


<form role="form" accept-charset="utf-8" class="form-horizontal" id="crearModule" method="POST" action="?v=modules&action=editModule">
          <fieldset><legend>Edición de modulo</legend>
            <div class="form-group">
                <label class="control-label" for="inputEmail">Nombre</label>
                <div class="controls">
                    <input 
                        type="hidden"
                        name="id_module" 
                        value="<?= $item->getIdModule() ?>" />
                    <input class="form-control stringField signedField notNulleable" 
                           maxsize=""  
                           required="required"  
                           placeholder="Name"  
                           id="Name"  
                           name="name" 
                           value="<?= $item->getName() ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputEmail">Path</label>
                <div class="controls">
                    <input 
                        class="form-control stringField signedField notNulleable" 
                        maxsize=""  
                        required="required"  
                        placeholder="Path"  
                        id="Path"  name="path" value="<?= $item->getPath() ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputEmail">Modulo padre</label>
                <div class="controls">
                    <select name="id_parent">
                        <option value="PARENT">Sin padre</option>
                        <?php
                        if (is_array($modList)) {
                            foreach ($modList as $modItem) {
                                ?><option 
                                    value="<?= $modItem['id_module'] ?>"
                                    <?php
                                    if ($modItem['id_module'] == $item->getIdParent()) {
                                        echo 'selected="selected"';
                                    }
                                    ?>
                                    >
                                        <?= $modItem['name'] ?>
                                </option><?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputEmail">Mostrar</label>
                <div class="controls">
                    <select name="visible">
                        <option value="NO"
                        <?php
                        if ($modItem['visible'] == 0) {
                            echo 'selected="selected"';
                        }
                        ?>>no</option>
                        <option value="SI"
                        <?php
                        if ($modItem['visible'] == 1) {
                            echo 'selected="selected"';
                        }
                        ?>>si</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="controls">
                    <button type="submit" class=" btn">Editar módulo</button>
                </div>
            </div>
        </fieldset></form>


<?php } else { ?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>¡Ocurrio un error!</strong> El módulo indicado no existe.
    </div>
<?php } ?>

