<?php
if($this->acl->acl("Agregar")){


?>
<div class="span9">
    
    <h1>Agregar Departamento</h1>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong> y <strong>Estado</strong> son obligatorios</span>, <span class="label label-info">el campo C&oacute;digo es opcional</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=departamento&action=insertDepto">
        <label><span class="text-warning">*</span> Nombre:</label>
      <input type="text" class="input-xlarge" name="nombre" placeholder="Nombre del departamento" />      
      <label><span class="text-warning">*</span> Estado:</label>
      <select name="estado">
          <option selected="selected" value="1">Activo</option>
          <option value="0">Inactivo</option>
      </select>
      <label>C&oacute;digo:</label>
      <input type="text" class="input-large" name="codigo" placeholder="codigo opcional" /><br />
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


