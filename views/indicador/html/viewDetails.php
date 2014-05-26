<?php
if(1){
    MasterController::requerirModelo("indicador");
    $item = new indicador();
    $item->indicador_id['val'] = $_GET['itemId'];
    $tx = new ClassTransaction();
    $tx->loadClass($item);
    $values = $tx->returnObjectValues();
    
    $item->nombre['val'] = $values['nombre']; 
    $item->indicador_id['val'] = $values['indicador_id'];
    $item->descripcion['val'] = $values['descripcion'];
    $item->estandar_id['val'] = $values['estandar_id'];
    
    
    

?>
<div class="span9">
    
    <h3>Detalles del indicador</h3>
    
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    
    
    <dl>
      <dt>ID</dt>
      <dd><?php echo $item->indicador_id['val']?></dd>
    </dl>
    <dl>
      <dt>Nombre</dt>
      <dd><?php echo $item->nombre['val']?></dd>
    </dl>
    <dl>
      <dt>Descripci&oacute;n</dt>
      <dd><?php echo $item->descripcion['val']?></dd>
    </dl>
    
    
    <?php
    MasterController::requerirClase("MysqlSelect");
    $mselect =  new MysqlSelect();
    $mselect->setTableReference("valor_indicador");
    $mselect->addFilter("valor_indicador", "indicador_id", $item->indicador_id['val'], "=");
    $mselect->execute();
    if($mselect->rowsCount() > 0){        
        
        ?>
        <h4>Valores de selecci&oacute;n para el indicador</h4>
        <table class="table table-hover table-bordered table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>valor</th>
                
            </tr>
        </thead>
        
        <?php
        foreach($mselect->rows AS $row => $r){
            ?>
        <tr>
            <td><?=$r['valor_indicador_id']?></td>
            <td><?=$r['valor']?></td>
            
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


