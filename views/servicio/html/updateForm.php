<?php
if($this->acl->acl("Modificar")){
    
    
    
    MasterController::requerirModelo("servicio_intrahospitalario");
    $item = new servicio_intrahospitalario();
    $item->setServicioIntrahospitalarioId($_GET['itemId']);
    
    
    /*MasterController::requerirClase("MysqlSelect");
    $mselect =  new MysqlSelect();
    $mselect->setTableReference("indicador");
    $mselect->addCustomSelection("indicador.*");
    $mselect->addSelection("estandar", "nombre","estandar_nombre");
    $mselect->addJoin("estandar", "estandar_id", "=", "indicador", "estandar_id", "LEFT");
    $mselect->addFilter("indicador", "indicador_id", $item->indicador_id['val'], "=");
    $mselect->execute();
    foreach($this->grid AS $row => $r){}
    */
    $item->getValuesBySetedId();
    /*
    $tx = new ClassTransaction();
    $tx->loadClass($item);
    $values = $tx->returnObjectValues();
    
    $item->nombre['val'] = $values['nombre']; 
    $item->estandar_id['val'] = $values['estandar_id'];
    $item->descripcion['val'] = $values['descripcion'];
    */
?>
<div class="span9">
    
    <h1>Editar servicio intra-hospitalario</h1>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong> y <strong>Estado</strong> son obligatorios</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=indicador&action=update" class="form-horizontal" accept-charset="utf-8"> 
        <div class="control-group">
            <label class="control-label" >ID:</label>        
        
            <div class="controls">
                <span class="input-small uneditable-input"><?php echo $item->getServicioIntrahospitalarioId()?></span>
                <input type="hidden" class="input-small" name="indicador_id" value="<?php echo $item->getServicioIntrahospitalarioId()?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" ><span class="text-warning">*</span> Nombre:</label>
            <div class="controls">
                <input type="text" class="input-xxlarge" name="nombre" value="<?php echo $item->getNombre()?>" placeholder="Nombre del servicio intra-hospitalario" />
            </div>
        </div>
        
        <div class="control-group">
        
            <label class="control-label" ><span class="text-warning">*</span> Estandar:</label>
            <div class="controls">
                <select name="estandar_id" id="select_estandar_combo_box">

                    <?

                     $mselect =  new MysqlSelect();
                     $mselect->setTableReference("estandar");
                     $mselect->addFilter("estandar", "estado", "1", "=");

                     if($mselect->execute()){
                        $grid = $mselect->rows;                    
                        foreach($grid AS $r){
                            ?><option <?php if($item->getEstandarId()==$r['estandar_id']){ echo 'selected="selected"';} ?> value="<?=$r['estandar_id']?>"><?=$r['nombre']?></option><?
                        }

                    }

                     ?>
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


