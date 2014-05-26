<?php
if($this->acl->acl("Agregar")){


?>
<div class="span9">
    
    <h3>Agregar Indicador</h3>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong> y <strong>Estandar</strong> son obligatorios</span>.
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=indicador&action=insert" accept-charset="utf-8">
      <label><span class="text-warning">*</span> Nombre:</label>
      <input type="text" class="input-xlarge" name="nombre" placeholder="Nombre del indicador" />      
      <label><span class="text-warning">*</span> Estandar:</label>
      <select name="estandar_id" id="select_estandar_combo_box">
                    
                <?
                 
                 $mselect =  new MysqlSelect();
                 $mselect->setTableReference("estandar");
                 $mselect->addFilter("estandar", "estado", "1", "=");
                 
                 if($mselect->execute()){
                    $grid = $mselect->rows;                    
                    foreach($grid AS $r){
                        ?><option value="<?=$r['estandar_id']?>"><?=$r['nombre']?></option><?
                    }

                }

                 ?>
    </select>
      <label>Descripci&oacute;n:</label>
      <textarea class="input-xlarge" name="descripcion" placeholder="Descripcion"></textarea>
      
      <br />
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


