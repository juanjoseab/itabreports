<?php
if($this->acl->acl("Modificar")){
    MasterController::requerirModelo("estandar");
    $item = new estandar();
    $item->estandar_id['val'] = $_GET['itemId'];
    $tx = new ClassTransaction();
    $tx->loadClass($item);
    $values = $tx->returnObjectValues();
    
    $item->nombre['val'] = $values['nombre']; 
    $item->estandar_id['val'] = $values['estandar_id'];
    $item->estado['val'] = $values['estado'];
    
    
    

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
    
    <form  method="post" action="?v=estandares&action=update" class="form-horizontal"> 
        <div class="control-group">
            <label class="control-label" >ID:</label>        
        
            <div class="controls">
                <span class="input-small uneditable-input"><?php echo $item->estandar_id['val']?></span>
                <input type="hidden" class="input-small" name="estandar_id" value="<?php echo $item->estandar_id['val']?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" ><span class="text-warning">*</span> Nombre:</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="nombre" value="<?php echo $item->nombre['val']?>" placeholder="Nombre del area de salud" />
            </div>
        </div>
        
        
        <div class="control-group">
            <label class="control-label" ><span class="text-warning">*</span> Estado:</label>
            <div class="controls">
                <select name="estado" class="input-xlarge">
                    <option <?php if($item->estado['val']==1){  ?>selected="selected" <? } ?> value="1">Activo</option>
                    <option <?php if($item->estado['val']==0){  ?>selected="selected" <? } ?>value="0">Inactivo</option>
                </select>
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
               
                <button type="submit" class="btn">Editar</button>
            </div>
        </div>
        
        
        
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


