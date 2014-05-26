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
    
    <h3>Detalles del estandar</h3>
    
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    
    
    <dl class="dl-horizontal">
      <dt>ID</dt>
      <dd><?php echo $item->estandar_id['val']?></dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Nombre</dt>
      <dd><?php echo $item->nombre['val']?></dd>
    </dl>
    <dl class="dl-horizontal">
      <dt>Estado</dt>
      <dd><? if ($item->estado['val']==1) { ?>
                    <span class="btn btn-success">Activa</span>
                    <? }else{ ?>
                    <span class="btn btn-danger">Inactiva</span>
                    <? }?></dd>
    </dl>
    
    <?php
    MasterController::requerirClase("MysqlSelect");
    $mselect =  new MysqlSelect();
    $mselect->setTableReference("indicador");
    $mselect->addFilter("indicador", "estandar_id", $item->estandar_id['val'], "=");
    $mselect->execute();
    if($mselect->rowsCount() > 0){        
        
        ?>
        <h4>Indicadores</h4>
        <table class="table table-hover table-bordered table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripci&oacute;n</th>
            </tr>
        </thead>
        
        <?php
        foreach($mselect->rows AS $row => $r){
            ?>
        <tr>
            <td><?=$r['indicador_id']?></td>
            <td><?=$r['nombre']?></td>
            <td><?=$r['descripcion']?></td>
        </tr>
        <?php } ?>
         </table>
        <?
        
        
    }
    
    
    ?>
        <?php
    MasterController::requerirClase("MysqlSelect");
    $mselect =  new MysqlSelect();
    $mselect->setTableReference("servicio_intrahospitalario");
    $mselect->addFilter("servicio_intrahospitalario", "estandar_id", $item->estandar_id['val'], "=");
    $mselect->execute();
    if($mselect->rowsCount() > 0){        
        
        ?>
        <h4>Servicios Intra-Hospitalarios a los que aplica</h4>
        <table class="table table-hover table-bordered table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>                
            </tr>
        </thead>
        
        <?php
        foreach($mselect->rows AS $row => $r){
            ?>
        <tr>
            <td><?=$r['servicio_intrahospitalario_id']?></td>
            <td><?=$r['nombre']?></td>
            
        </tr>
        <?php } ?>
         </table>
        <?
        
        
    }
    
    
    ?>
    
    

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


