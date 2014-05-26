<script type="text/javascript" language="javascript">
$(function(){
    
    $("select#select_departamento_combo_box").change(function(){
        $("select#select_municipio_combo_box option").remove();
        $.ajax({
            url:        '?v=das&action=returnOptions&referencia=municipios&itemId='+$(this).val(),
            type:       'GET',
            data:       '',
            success:    function(res){
                $("select#select_municipio_combo_box").append(res);
            }
        });
    })
    
})
</script>

<?php
MasterController::requerirClase("MysqlSelect");
if($this->acl->acl("Agregar")){


?>
<div class="span9">
    
    <h2>Agregar distrito de salud</h2>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong>, <strong>Estado</strong>, <strong>Departamento</strong> y <strong>&Aacute;rea de salud</strong> son obligatorios</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=dms&action=insert">
      <div class="control-group">
            <label class="control-label">&Aacute;rea de salud</label>
            <div class="controls">
                <select name="area_salud_id" id="select_das_combo_box">
                    
                <?
                 
                 $mselect =  new MysqlSelect();
                 $mselect->setTableReference("area_salud");
                 $mselect->addFilter("area_salud", "estado", "1", "=");
                 
                 if($mselect->execute()){
                    $grid = $mselect->rows;                    
                    foreach($grid AS $r){
                        ?><option value="<?=$r['area_salud_id']?>"><?=$r['nombre']?></option><?
                    }

                }

                 ?>
                </select>
                
            </div>
            <label class="control-label">Nombre del distrito</label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="Nombre" name="nombre" />
            </div>
            <label class="control-label">Departamento</label>
            <div class="controls">
                <select name="departamento_id" id="select_departamento_combo_box">
                    <option value="0">Elija un departamento</option>
                <?
                 
                 $mselect =  new MysqlSelect();
                 $mselect->setTableReference("departamento");
                 $mselect->addFilter("departamento", "estado", "1", "=");
                 
                 if($mselect->execute()){
                    $grid = $mselect->rows;                    
                    foreach($grid AS $dep){
                        ?><option value="<?=$dep['departamento_id']?>"><?=$dep['nombre']?></option><?
                    }

                }

                 ?>
                </select>
            </div>
            <label class="control-label">Municipio</label>
            <div class="controls">
                <select name="municipio_id" id="select_municipio_combo_box" >
                    
                </select>
            </div>            
            
            <label class="control-label">Estado</label>
            <div class="controls">
                <select name="estado">
                  <option selected="selected" value="1">Activo</option>
                  <option value="0">Inactivo</option>
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


