<?php
if($this->acl->acl("Modificar")){
    MasterController::requerirModelo("departamento");
    $item = new departamento();
    $item->departamento_id['val'] = $_GET['itemId'];
    $tx = new ClassTransaction();
    $tx->loadClass($item);
    $values = $tx->returnObjectValues();
    
    $item->nombre['val'] = $values['nombre']; 
    $item->codigo['val'] = $values['codigo'];
    $item->estado['val'] = $values['estado'];
    //$item->estado['val'] = 0;
    
    
    

?>
<div class="span9">
    
    <h1>Editar Departamento</h1>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong> y <strong>Estado</strong> son obligatorios</span>, <span class="label label-info">el campo C&oacute;digo es opcional</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=departamento&action=update">
        <label>ID:</label>        
        <span class="input-small uneditable-input"><?php echo $item->departamento_id['val']?></span>
        <input type="hidden" class="input-small" name="departamento_id" value="<?php echo $item->departamento_id['val']?>" />
        <label><span class="text-warning">*</span> Nombre:</label>
        <input type="text" class="input-xlarge" name="nombre" value="<?php echo $item->nombre['val']?>" placeholder="Nombre del departamento" />      
        <label><span class="text-warning">*</span> Estado:</label>        
        <select name="estado">
            <option <?php if($item->estado['val']==1){  ?>selected="selected" <? } ?> value="1">Activo</option>
            <option <?php if($item->estado['val']==0){  ?>selected="selected" <? } ?>value="0">Inactivo</option>
        </select>
        <label>C&oacute;digo:</label>
        <input type="text" class="input-large" name="codigo" placeholder="codigo opcional"  value="<?php echo $item->codigo['val'];?>" /><br />
        <button type="submit" class="btn">Editar</button>
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


