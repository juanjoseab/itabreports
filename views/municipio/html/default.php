<script type="text/javascript" lang="JavaScript">
    $(function(){
        
        $('#myModal').modal();
        $('#myModal').modal('hide');
        $("div#filtros_tabla").hide();
        $("#verfiltros").click(function(){
            $("div#filtros_tabla").toggle();
        })
        
        
        
        $("a.doOpenModal").click(function(){
            $("#myModal input#departamentoIdToSubmit").val("");
            $("#myModal input#departamentoNombre").val("");
            var did = $(this).attr("reldid");
            var mid = $(this).attr("relmid");
            
            var dname = $(this).attr("reldname");
            var mname = $(this).attr("relmname");
            
            $('#myModal').modal('show');
            $("#myModal input#departamentoIdToSubmit").val(did);
            $("#myModal input#departamentoNombre").val(dname);
            $("#myModal input#municipioIdToSubmit").val(mid);
            $("#myModal input#municipioNombre").val(mname);
            
            
            
            
            
        });
        
        

    
    $("#sendSumbit").click(function(){
    
        $("#myModal .modal-body").addClass("customLoading");
        //alert();
        $("form#addLPForm > div, button#sendSumbit").slideUp();        
        var datos = $("form#addLPForm").serialize();
        $.ajax({
          url:      "?v=municipio&action=addLugarPoblado",
          data:     datos,
          type:     "POST",
          success:  function(res){
              $("form#addLPForm").prepend(res);
              $("#myModal .modal-body").removeClass("customLoading");              
              $("form#addLPForm input#Nombre").val("");
              $("form#addLPForm input#Codigo").val("");
               $("#addOther").show();
          }
        })
        
        
        
        return false;
    })
    
    $("#addOther").click(function(){
        $(".alert").remove();
        $("form#addLPForm > div, button#sendSumbit").show();
        $(this).hide();
    });
        
        
    });
</script>
<div class="span9">
<h1>Municipios</h1>

     <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>


<? $this->createDepartamentoGrid(false);?>

    <div class="row-fluid">
        <div class="span1">
            <button type="button" class="btn" data-toggle="button" id="verfiltros">filtros</button>
        </div>
     <div class="span10" id="filtros_tabla">
         <form id="filterForm" class="form-inline" action="?v=municipio&filtro=1" method="POST">
             <?
             MasterController::requerirClase("MysqlSelect");
             $mselect =  new MysqlSelect();
             $mselect->setTableReference("municipio");
             $mselect->addSelection("municipio", "municipio_id");
             $mselect->addSelection("departamento", "departamento_id");
             $mselect->addSelection("departamento", "nombre");
             $mselect->addJoin("departamento", "departamento_id", "=", "municipio", "departamento_id", "LEFT");
             $mselect->addGroup("departamento", "departamento_id");
             if($mselect->execute()){
                $grid = $mselect->rows;
                echo "<select name=\"departamentoId\" >
                        <option value=\"0\">Todos los departamentos</option>";
                foreach($grid AS $dep){
                    ?><option value="<?=$dep['departamento_id']?>"><?=$dep['nombre']?></option><?
                }
                echo "</select>";
            }
             
             ?>
            <button type="submit" class="btn">filtrar</button>
         </form>
     </div>
    
    
</div>
    
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
            
        
        <? if (count ($this->grid) > 0){ 
            foreach($this->grid AS $row => $r){
        ?>
        <tr>
            <td><?=$r['municipio_id']?></td>
            <td><?=$r['nombre']?></td>
            <td><?=$r['departamento_nombre']?></td>
            <td>
                    <? if ($r['estado']==1) { ?>
                    <span class="btn btn-success">Activo</span>
                    <? }else{ ?>
                    <span class="btn btn-danger">Inactivo</span>
                    <? }?>
                
            </td>
            <td>
                <div class="btn-group">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    Opciones
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                      
                      <? if($this->acl->acl("Agregar")){ ?>
                        <li><a class="doOpenModal" 
                               href="?v=municipio" 
                               reldid="<?=$r['departamento_id']?>" 
                               reldname="<?=$r['departamento_nombre']?>" 
                               relmid="<?=$r['municipio_id']?>" 
                               relmname="<?=$r['nombre']?>" 
                               data-toggle="modal" 
                               data-target="#modal">Agregar Lugar poblado</a></li>
                      <?}?> 
                    
                      <? if($this->acl->acl("Modificar")){ ?>
                        <li><a class="needAlertConfirm" href="?v=municipio&action=viewUpdateForm&itemId=<?=$r['municipio_id']?>&did=<?=$r['departamento_id']?>">Editar</a></li>
                      <?}?>
                      
                      <? if($this->acl->acl("Desactivar")){ ?>
                        <li><a class="needAlertConfirm" href="#">Desactivar</a></li>
                      <?}?>  
                      
                      <? if($this->acl->acl("Eliminar")){ ?>
                        <li><a class="needAlertConfirm" href="?v=municipio&action=delete&itemId=<?=$r['municipio_id']?>">Eliminar</a></li>
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
        if($_GET['filtro']==1){
            if($_POST['departamentoId']){
                $extras = "filtro=1&departamentoId=".$_POST['departamentoId'];
            }elseif($_GET['departamentoId']){
                $extras = "filtro=1&departamentoId=".$_GET['departamentoId'];
            }
            
        }
        $pags = $this->getArrayPaginacion();
        if($_GET['pag']==0 || !$_GET['pag'] ){
            $pageActive = 0;
        }else{
            $pageActive = $_GET['pag'];
        }
        ?> 
    <div class="pagination pagination-centered">
        <ul>
            <li><a href="<?php echo $this->returnThisUrl($extras); ?>&pag=0">Primero</a></li>
            <?php
            if(count($pags)==1){
            ?>
            <li class="active"><a href="#">1</a></li>
            <?
            }else{
                foreach ($pags as $pag){
                ?>
            <li <?php if($pag==$pageActive){echo 'class="active"';} ?>><a href="<?php echo $this->returnThisUrl($extras); ?>&pag=<?=$pag?>"><?=($pag+1)?></a></li>
                <?
                }
            }
            
            ?>
            <li><a href="<?php echo $this->returnThisUrl($extras); ?>&pag=<?=($this->getPaginacionPosition())-1 ?>">Ultimo</a></li>
        </ul>
    </div>
    
    
</div>

