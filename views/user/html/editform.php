<?php
MasterController::requerirModelo("user");
$user = new user();
$user->setIdUser($_GET['uid']);
$user->getValuesBySetedId();

if($user->getLogin()){

$alerts = $this->activesMsgs();
if ($alerts) {
    echo $alerts;
}
?>

<form role="form" accept-charset="utf-8" class="form-horizontal" id="editUsuario" method="POST" action="?v=user&action=editUser" 
      
      <fieldset><legend>Editar usuario</legend>
          <input type="hidden" name="id_user" value="<?=$user->getIdUser()?>" />
        <div class="form-group">
            <label class="control-label" for="inputEmail">Nombre</label>
            <div class="controls">
                <input class="form-control stringField signedField notNulleable" maxsize=""  required="required"  placeholder="Name"  id="Name"  name="name" value="<?=$user->getName()?>" />
            </div>
        </div><div class="form-group">
            <label class="control-label" for="inputEmail">Login</label>
            <div class="controls">
                <input class="form-control stringField signedField notNulleable" maxsize=""  required="required"  placeholder="Login"  id="Login"  name="login" value="<?=$user->getLogin()?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Password</label>
            <div class="controls">
                <input class="form-control textField signedField notNulleable"   placeholder="Pass"  id="Pass"  name="pass" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Confirmar password</label>
            <div class="controls">
                <input class="form-control textField signedField notNulleable"  placeholder="Pass"  id="Pass"  name="repass" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="inputEmail">Status</label>
            <div class="controls">
                <select class=" form-control tinyintField unsignedField notNulleable"  required="required"  placeholder="Status"  id="Status"  name="status" >
                    <option  <?= ($user->getStatus()==1 )?'selected="selected"':'' ?> value="1">Activo</option>
                    <option  <?= ($user->getStatus()==0 )?'selected="selected"':'' ?>value="0">Inactivo</option></select>
            </div>
        </div><div class="form-group">
            <div class="controls">

                <button type="submit" class=" btn">Editar usuario</button>
            </div>
        </div>
    </fieldset></form>
<?php }else{ ?>
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>¡Ocurrio un error!</strong> El usuario indicado no existe.
</div>
<?php }?>

