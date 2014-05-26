<?php
if($this->acl->acl("Modificar")){
    MasterController::requerirClase("MysqlSelect");
    MasterController::requerirModelo("distrito_salud");
    $item = new distrito_salud();
    $item->municipio_id['val'] = $_GET['mid'];
    $item->area_salud_id['val'] = $_GET['dasid'];
    $item->distrito_salud_id['val'] = $_GET['itemId'];
    $tx = new ClassTransaction();
    $tx->loadClass($item);
    $values = $tx->returnObjectValues();
    
    $item->nombre['val'] = $values['nombre']; 
    $item->estado['val'] = $values['estado'];

    

?>
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

<div class="span9">
    
    <h2>Editar distrito de salud</h2>
    <p>
        Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong>, <strong>Estado</strong>, <strong>Departamento</strong> y <strong>&Aacute;rea de salud</strong> son obligatorios</span>
    </p>
    <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>
    
    <form  method="post" action="?v=dms&action=update">
      <div class="control-group">            
            <label class="control-label">ID</label>
            <div class="controls">
                <input type="text" class="input-small" readonly="readonly" id="Id" name="distrito_salud_id" value="<?=$item->distrito_salud_id['val']?>" />
            </div>
          
            <label class="control-label">Nombre del distrito</label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="Nombre" name="nombre" value="<?=$item->nombre['val']?>" />
            </div>
            
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
                        ?><option <? if($r['area_salud_id']==$item->area_salud_id['val']){ echo 'selected="selected"'; } ?>   value="<?=$r['area_salud_id']?>"><?=$r['nombre']?></option><?
                    }

                }

                 ?>
                </select>
                
            </div>
            
            <label class="control-label">Departamento</label>
            <div class="controls">
                <select name="departamento_id" id="select_departamento_combo_box">
                    
                <?
                 
                 $mselect =  new MysqlSelect();
                 $mselect->setTableReference("departamento");
                 $mselect->addFilter("departamento", "estado", "1", "=");
                 
                 if($mselect->execute()){
                    $grid = $mselect->rows;                    
                    foreach($grid AS $dep){
                        ?><option <? if($dep['departamento_id']==$_GET['depid']){ echo 'selected="selected"'; } ?>  value="<?=$dep['departamento_id']?>"><?=$dep['nombre']?></option><?
                    }

                }

                 ?>
                </select>
            </div>
            <label class="control-label">Municipio</label>
            <div class="controls">
                <select name="municipio_id" id="select_municipio_combo_box" >
                    <?
                 
                 $mselect =  new MysqlSelect();
                 $mselect->setTableReference("municipio");
                 $mselect->addFilter("municipio", "estado", "1", "=");
                 $mselect->addFilter("municipio", "departamento_id", $_GET['depid'], "=");
                 
                 if($mselect->execute()){
                    $grid = $mselect->rows;                    
                    foreach($grid AS $r){
                        ?><option <? if($r['municipio_id']==$_GET['mid']){ echo 'selected="selected"'; } ?>  value="<?=$r['municipio_id']?>"><?=$r['nombre']?></option><?
                    }

                }

                 ?>
                </select>
            </div>            
            
            <label class="control-label">Estado</label>
            <div class="controls">
                <select name="estado">                  
                    <option <?php if($item->estado['val']==1){  ?>selected="selected" <? } ?> value="1">Activo</option>
                    <option <?php if($item->estado['val']==0){  ?>selected="selected" <? } ?>value="0">Inactivo</option>
                </select>
              </select>
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


