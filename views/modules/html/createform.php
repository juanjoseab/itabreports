<?php
MasterController::requerirModelo("module");
$mod = new module();
//$modList = $mod->getList(array(), array("id_parent" => array(" ", " IS NULL ")));
$modList = $mod->getList(array(), array("id_parent" => array("1", "IS NULL AND '1' = ")));
?>
<?php
$alerts = $this->activesMsgs();
if ($alerts) {
    echo $alerts;
}
?>

<form role="form" accept-charset="utf-8" class="form-horizontal" id="crearModule" method="POST" action="?v=modules&action=createModule" 
      <fieldset><legend>Crear modulo</legend>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Nombre</label>
            <div class="controls">
                <input class="form-control stringField signedField notNulleable" maxsize=""  required="required"  placeholder="Name"  id="Name"  name="name" value="" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Path</label>
            <div class="controls">
                <input class="form-control stringField signedField notNulleable" maxsize=""  required="required"  placeholder="Path"  id="Login"  name="path" value="" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Modulo padre</label>
            <div class="controls">
                <select name="id_parent">
                    <option value="PARENT">Sin padre</option>
                    <?php
                    if (is_array($modList)) {
                        foreach ($modList as $item) {
                            ?><option value="<?= $item['id_module'] ?>"><?= $item['name'] ?></option><?php
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
                    <option value="NO">no</option>
                    <option value="SI">si</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="controls">
                <button type="submit" class=" btn">Crear módulo</button>
            </div>
        </div>
    </fieldset></form>
