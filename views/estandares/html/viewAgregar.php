<?php
if($this->acl->acl("Agregar")){


?>
<div class="span9">
    
    <h1>Agregar Estandar</h1>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong> y <strong>Estado</strong> son obligatorios</span>, <span class="label label-info">el campo C&oacute;digo es opcional</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=estandares&action=insert">
      <label><span class="text-warning">*</span> Nombre:</label>
      <input type="text" class="input-xlarge" name="nombre" placeholder="Nombre del Estandar" />      
      <label><span class="text-warning">*</span> Estado:</label>
      <select name="estado">
          <option selected="selected" value="1">Activa</option>
          <option value="0">Inactiva</option>
      </select><br />
      <button type="submit" class="btn">Agregar</button>
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


