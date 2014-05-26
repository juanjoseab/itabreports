<div class="row-fluid">
  
  <div class="span6 offset2">
      <?php if ($this->error) {
          ?>
          <div class="alert alert-error alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <h4>Error en el registro!</h4>
          Es posible que el usuario y/o la clave esten incorrectos, por favor intente de nuevo
          </div>
          <?php
          
      }?>
      
      <form class="form-horizontal" action="?v=login&action=register" method="post">
      <div class="control-group">
        <label class="control-label" for="usuario">Usuario</label>
        <div class="controls">
          <input type="text" id="usuario" name="usuario" placeholder="Nombre de usuario">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="passwd">Password</label>
        <div class="controls">
          <input type="password" id="passwd" name="passwd" placeholder="Password">
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          
          <button type="submit" class="btn">Ingresar</button>
        </div>
      </div>
    </form>  
      
  </div>
</div>

    

    