

<?php

if($this->acl->acl("Administrar Usuarios")){

MasterController::requerirClase("MysqlSelect");
?>
<script type="text/javascript" lang="JavaScript">
    $(function(){
       
        
        
    });
</script>
<div class="span9">
<h1>Usuarios</h1>

     <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>


<? $this->createRolGrid();?>


    
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>                
                <th>Opciones</th>
            </tr>
        </thead>
            
        
        <? if (count ($this->grid) > 0){ 
            foreach($this->grid AS $row => $r){
        ?>
        <tr>
            <td><?=$r['rol_id']?></td>
            <td><?=$r['nombre']?></td>            
            <td>
                <div class="btn-group">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    Opciones
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                      
                    
                      <? if($this->acl->acl("Modificar")){ ?>
                        <li><a href="?v=usuario&action=viewUpdateForm&itemId=<?=$r['distrito_salud_id']?>&mid=<?=$r['municipio_id']?>&dasid=<?=$r['area_salud_id']?>&depid=<?=$r['departamento_id']?>">Editar</a></li>
                      <?}?>
                      
                      <? if($this->acl->acl("Desactivar")){ ?>
                        <li><a class="needAlertConfirm" href="#">Desactivar</a></li>
                      <?}?>  
                      
                      <? if($this->acl->acl("Eliminar")){ ?>
                        <li><a class="needAlertConfirm" href="?v=usuario&action=delete&itemId=<?=$r['distrito_salud_id']?>">Eliminar</a></li>
                      <?}?>
                      
                  </ul>
                </div>
                
            </td>
        </tr>
        <? 
            }
        } ?>
    </table>
    <? 
        
        $pags = $this->getArrayPaginacion();
        if($_GET['pag']==0 || !$_GET['pag'] ){
            $pageActive = 0;
        }else{
            $pageActive = $_GET['pag'];
        }
        ?> 
    <div class="pagination">
        <ul>
            <?php
            if(count($pags)==1){
            ?>
            <li class="active"><a href="#">1</a></li>
            <?
            }else{
                foreach ($pags as $pag){
                ?>
            <li <?php if($pag==$pageActive){echo 'class="active"';} ?>><a href="<?php echo $this->returnThisUrl($extras); ?>&usuario=<?=$pag?>"><?=($pag+1)?></a></li>
                <?
                }
            }
            
            ?>
        </ul>
    </div>
    
    
</div>




<?php } ?>

<?php
    /*
    $this->loadContentView("default");
    $this->getContentView();
     */
?>


