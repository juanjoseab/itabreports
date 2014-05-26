<script type="text/javascript" lang="JavaScript">
    $(function(){
        
        $('#myModal').modal();
        $('#myModal').modal('hide');
        $("div#filtros_tabla").hide();
        $("#verfiltros").click(function(){
            $("div#filtros_tabla").toggle();
        })
        
        
        
        $("a.doOpenModal").click(function(){
            $("#myModal input#valorToSubmit").val("");            
            var relid = $(this).attr("relid");
            var relname = $(this).attr("relname");
            
            
            $('#myModal').modal('show');
            $("#myModal input#indicadorId").val(relid);
            $("#myModal input#indicadorNombre").val(relname);
            
            
            
            
            
            
        });
        
        

    
    $("#sendSumbit").click(function(){
    
        $("#myModal .modal-body").addClass("customLoading");
        //alert();
        $("form#addChildForm > div, button#sendSumbit").slideUp();        
        var datos = $("form#addChildForm").serialize();
        $.ajax({
          url:      "?v=indicador&action=addChild",
          data:     datos,
          type:     "POST",
          success:  function(res){              
              $("form#addChildForm").prepend(res);
              $("#myModal .modal-body").removeClass("customLoading");
              $("form#addChildForm input#valorToSubmit").val("");
              $("#addOther").show();
          }
        })
        
        
        
        return false;
    })
    
    $("#addOther").click(function(){
        $(".alert").remove();
        $("form#addChildForm > div, button#sendSumbit").show();
        $(this).hide();
    });
    
    
    
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
        
        
    $('#myModal').on('hidden', function () {
        $(".alert").remove();
        $("form#addChildForm > div, button#sendSumbit").show();
        $("#addOther").hide();
    })
        
    });
</script>
<h1>Lista de indicadores</h1>

     <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>


<? $this->createGrid(false);?>
<div class="span9">
    
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
            <td><?=$r['indicador_id']?></td>
            <td><?=$r['nombre']?></td>
            <td><?=$r['estandar_nombre']?></td>
            
            <td>
                <div class="btn-group">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    Opciones
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                      
                      <? if($this->acl->acl("Agregar")){ ?>
                        <li><a class="doOpenModal"
                               href="?v=indicador" 
                               relid="<?=$r['indicador_id']?>"
                               relname="<?=$r['nombre']?>"
                               data-toggle="modal"
                               data-target="#modal">Asignar valor de selecci&oacute;n</a></li>
                      <?}?> 
                    
                      <? if($this->acl->acl("Modificar")){ ?>
                        <li><a href="?v=indicador&action=viewUpdateForm&itemId=<?=$r['indicador_id']?>">Editar</a></li>
                      <?}?>
                      <li><a href="?v=indicador&action=viewDetails&itemId=<?=$r['indicador_id']?>">Ver detalles</a></li>
                          <? if($this->acl->acl("Eliminar")){ ?>
                        <li><a class="needAlertConfirm" href="?v=indicador&action=delete&itemId=<?=$r['indicador_id']?>">Eliminar</a></li>
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
            <li <?php if($pag==$pageActive){echo 'class="active"';} ?>><a href="?v=indicador&pag=<?=$pag?>"><?=($pag+1)?></a></li>
                <?
                }
            }
            
            ?>
        </ul>
    </div>
    
    
</div>

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Agregar Valor de Selecci&oacute;n</h3>
  </div>
  <div class="modal-body">
    
      <form class="form-horizontal" action="?v=indicador&action=addChild" accept-charset="utf-8" method="post" id="addChildForm">
        
        <div class="control-group">
            <label class="control-label">Valor de Selecci&oacute;n</label>
            <div class="controls">
                <input type="text" readonly="readonly" class="input-xlarge" id="indicadorNombre" name="indicadorNombre" />
                <input type="hidden" id="indicadorId" name="indicador_id" value="" />
            </div>
            <label class="control-label">Valor</label>
            <div class="controls">
                <input type="text" class="input-xlarge" placeholder="Valor de seleccion" id="valorToSubmit" name="valor" />
            </div>
            
            
        </div>
        
    </form>
      <button type="button" class="btn btn-info" id="addOther" style="display: none;">Agregar Otro</button>
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    <button class="btn btn-primary" id="sendSumbit">Guardar</button>
    
  </div>
</div>
