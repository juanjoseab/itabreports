<?php
MasterController::requerirModelo("user");
$user = new user();
/* echo $user->constructForm(
  "crearUsuario",
  "?v=user&action=createUser",
  "Crear usuario",
  "POST",
  "Crear usuario",
  FALSE);
 */
?>
<?php
                    $alerts = $this->activesMsgs();
                    if ($alerts) {
                        echo  $alerts;
                    }
                    ?>

<form role="form" accept-charset="utf-8" class="form-horizontal" id="crearUsuario" method="POST" action="?v=user&action=createUser" 
      <fieldset><legend>Crear usuario</legend>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Nombre</label>
            <div class="controls">
                <input class="form-control stringField signedField notNulleable" maxsize=""  required="required"  placeholder="Name"  id="Name"  name="name" value="" />
            </div>
        </div><div class="form-group">
            <label class="control-label" for="inputEmail">Login</label>
            <div class="controls">
                <input class="form-control stringField signedField notNulleable" maxsize=""  required="required"  placeholder="Login"  id="Login"  name="login" value="" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Password</label>
            <div class="controls">
                <input class="form-control textField signedField notNulleable"  required="required"  placeholder="Pass"  id="Pass"  name="pass" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Confirmar password</label>
            <div class="controls">
                <input class="form-control textField signedField notNulleable"  required="required"  placeholder="Pass"  id="Pass"  name="repass" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Status</label>
            <div class="controls">
                <select class=" form-control tinyintField unsignedField notNulleable"  required="required"  placeholder="Status"  id="Status"  name="status" ><option  selected="selected" value="1">Activo</option><option  value="0">Inactivo</option></select>
            </div>
        </div><div class="form-group">
            <div class="controls">

                <button type="submit" class=" btn">Crear usuario</button>
            </div>
        </div>
    </fieldset></form>
