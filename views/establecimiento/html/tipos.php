<script type="text/javascript" lang="JavaScript">
    $(function(){
        
        $('#myModal').modal();
        $('#myModal').modal('hide');

        $(".doOpenModal").click(function(){
            $('#myModal').modal('show');            
        });



    
    $("#sendSumbit").click(function(){
        $("#myModal .modal-body").addClass("customLoading");
        //alert();
        $("form#addLPForm > div, button#sendSumbit").slideUp();        
        var datos = $("form#addForm").serialize();
        $.ajax({
          url:      "?v=establecimiento&action=addTipoEstablecimiento",
          data:     datos,
          type:     "POST",
          success:  function(res){
              $("form#addForm").prepend(res);
              $("#myModal .modal-body").removeClass("customLoading");              
              $("form#addForm input#Nombre").val("");              
              $("#addOther").show();
          }
        })
        
        
        
        return false;
    })
    
    $("#addOther").click(function(){
        $(".alert").remove();
        $("form#addForm > div, button#sendSumbit").show();
        $(this).hide();
    });
        
        
    });
</script>

<div class="span9">
    <h1>Tipos de Establecimiento de Salud <button type="button" class="btn btn-primary doOpenModal">Agregar</button></h1>
    

     <?php
    $alerts = $this->activesMsgs();
    if($alerts){ echo $alerts; }
    ?>


    <? $this->createTiposGrid(false);?>
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
            <td><?=$r['tipo_establecimiento_salud_id']?></td>
            <td><?=$r['nombre']?></td>
            
            <td>
                <div class="btn-group">
                  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    Opciones
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                      <? if($this->acl->acl("Modificar")){ ?>
                        <li><a href="?v=establecimiento&action=viewTiposUpdateForm&itemId=<?=$r['tipo_establecimiento_salud_id']?>">Editar</a></li>
                      <?}?>
                      
                      
                      <? if($this->acl->acl("Eliminar")){ ?>
                        <li><a class="needAlertConfirm" href="?v=establecimiento&action=deleteTipo&itemId=<?=$r['tipo_establecimiento_salud_id']?>">Eliminar</a></li>
                      <?}?>
                      
                  </ul>
                </div>
                
            </td>
        </tr>
        <? 
            }
        } ?>
    </table>
</div>


<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Agregar tipo de servicio</h3>
  </div>
  <div class="modal-body">
    
      <form class="form-horizontal" action="?v=establecimiento&action=addTipoEstablecimiento" accept-charset="utf-8" method="post" id="addForm">
        
        <div class="control-group">
            <label class="control-label">Nombre</label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="Nombre" name="nombre" />
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