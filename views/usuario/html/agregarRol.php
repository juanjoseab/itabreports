

<?php

if($this->acl->acl("Administrar Usuarios")){

MasterController::requerirClase("MysqlSelect");
?>
<div class="span9">
    
    <h3>Agregar usuario</h3>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">todos los campos son obligatorios</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=usuario&action=insertRol" accept-charset="utf-8">
      <div class="control-group">
            <label class="control-label">Nombre</label>
            <input type="text" class="input-xlarge" id="Nombre" name="nombre" />
            
            
            
            <div class="controls">
                <select name="funciones[]" class="input-xxlarge" id="select_funciones_combo_box" multiple="multiple" style="height: 250px;">
                    
                <?
                 
                 $mselect =  new MysqlSelect();
                 $mselect->setTableReference("funcion");
                 
                 
                 if($mselect->execute()){
                    $grid = $mselect->rows;                    
                    foreach($grid AS $r){
                        ?><option value="<?=$r['funcion_id']?>"><?=$r['nombre']?></option><?
                    }

                }

                 ?>
                </select>
                
            </div>
            <div class="control-group">
                <div class="controls">
                  
                  <button type="submit" class="btn">Agregar</button>
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


