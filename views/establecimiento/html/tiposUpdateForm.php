<?php
if($this->acl->acl("Modificar")){
    MasterController::requerirClase("MysqlSelect");
    MasterController::requerirModelo("tipo_establecimiento_salud");
    $item = new tipo_establecimiento_salud();    
    $item->tipo_establecimiento_salud_id['val'] = $_GET['itemId'];
    $tx = new ClassTransaction();
    $tx->loadClass($item);
    $values = $tx->returnObjectValues();
    
    $item->nombre['val'] = $values['nombre']; 
    //print_r($item);
?>
<div class="span9">
    <h2>Editar tipo de establecimiento</h2>
    <p>
        Llene los campos que aparecen abajo
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=establecimiento&action=updateTipo">
      <div class="control-group">            
            <label class="control-label">ID</label>
            <div class="controls">
                <input type="text" class="input-small" readonly="readonly" id="Id" name="tipo_establecimiento_salud_id" value="<?=$item->tipo_establecimiento_salud_id['val']?>" />
            </div>
          
            <label class="control-label">Nombre del tipo</label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="Nombre" name="nombre" value="<?=$item->nombre['val']?>" />
            </div>
            
            
            <div class="control-group">
                <div class="controls">                  
                  <button type="submit" class="btn">Guardar</button>
                </div>
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


