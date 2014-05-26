<script type="text/javascript" lang="JavaScript">
    $(function(){
        
 
        $("div#filtros_tabla").hide();
        $("#verfiltros").click(function(){
            $("div#filtros_tabla").toggle();
        })
        
        
        
    
        
        
    });
</script>
<div class="span9">
<h3>Lista de servicios intra-hospitalarios</h3>

     <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>


<? $this->createGrid(false);?>

    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estandar</th>
                <th>Opciones</th>
            </tr>
        </thead>
            
        
        <? if (count ($this->grid) > 0){ 
            foreach($this->grid AS $row => $r){
        ?>
        <tr>
            <td><?=$r['servicio_intrahospitalario_id']?></td>
            <td><?=$r['nombre']?></td>
            <td><?=$r['estandar_nombre']?></td>
            
            <td>
                <div class="btn-group">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    Opciones
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                      
                                          
                      <? if($this->acl->acl("Modificar")){ ?>
                        <li><a href="?v=servicio&action=viewUpdateForm&itemId=<?=$r['servicio_intrahospitalario_id']?>">Editar</a></li>
                      <?}?>
                      
                          <? if($this->acl->acl("Eliminar")){ ?>
                        <li><a class="needAlertConfirm" href="?v=servicio&action=delete&itemId=<?=$r['servicio_intrahospitalario_id']?>">Eliminar</a></li>
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
            <li <?php if($pag==$pageActive){echo 'class="active"';} ?>><a href="?v=servicio&pag=<?=$pag?>"><?=($pag+1)?></a></li>
                <?
                }
            }
            
            ?>
        </ul>
    </div>
    
    
</div>
