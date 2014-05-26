<script type="text/javascript" language="JavaScript">
    $(function(){
        $("input#Reclave").keyup(function(){
            var thisval = $(this).val();
            var clave = $("input#Clave").val();
            //alert("ingresado :" + thisval + " - Clave: "+ clave);
            if(thisval == clave){
                $(this).css("border-color","#00FF00");
            }else{
                $(this).css("border-color","#FF0000");
            }
            activarEnviar();
        })
        
    $("input#Login").focus(function(){
        $(".text-error").remove();
        $(this).css("border-color","");
        
    });
        $("input#Login").blur(function(){
            var thisinp = $(this);
            var loginVal = $(this).val();
            if(loginVal!=""){
                $.ajax({
                    url:        "?v=usuario&action=verifyLogin",
                    data:       "login="+loginVal,
                    type:       "POST",
                    success:    function(res){
                        r = res * 1;
                        //alert(res + " -- " + r);
                        if(res==1){                            
                            thisinp.css("border-color","#FF0000");
                            thisinp.after(" <span class='text-error'>Login no disponible, elija otro</span>");
                            thisinp.attr("errFlag","true");
                        }else if(res==2){                            
                            thisinp.css("border-color","#00FF00");
                            thisinp.attr("errFlag","false");
                        }
                        activarEnviar();
                    }
                })
                
            }
                
        });
        
        function activarEnviar(){
            if( ($("input#Clave").val() != "") && ($("input#Reclave").val() == $("input#Clave").val())  &&  ($("input#Login").attr("errFlag") == "false" ) ){
                $("#submitButton").removeAttr("disabled");
                return true;
            }else{
                $("#submitButton").attr("disabled","disabled");
                return false;
            }
        }
        
        $("form#insertUserForm").submit(function(){
            if(activarEnviar()){
                return true;
            }else{
                alert('por favor verifique algun error en el formulario, ');
                return false;
            }
        })
    });
</script>



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
    
    <form  method="post" action="?v=usuario&action=insertUser" accept-charset="utf-8" id="insertUserForm">
      <div class="control-group">
            <label class="control-label">Nombre:</label>
            <input type="text" class="input-xlarge" id="Nombre" name="nombre" />
            <label class="control-label">Login de acceso: </label>
            <input type="text" class="input-xlarge" errFlag="vacio" id="Login" name="login" />
            
            <label class="control-label">Clave:</label>
            <input type="password" class="input-xlarge" id="Clave" name="clave" />
            
            <label class="control-label">Reingrese la clave:</label>
            <input type="password" class="input-xlarge" id="Reclave" name="reclave" />
            
            <label class="control-label">Rol a asingar:</label>
            <div class="controls">
                <select name="rol_id" id="select_rol_combo_box">
                    
                <?
                 
                 $mselect =  new MysqlSelect();
                 $mselect->setTableReference("rol");
                 
                 
                 if($mselect->execute()){
                    $grid = $mselect->rows;                    
                    foreach($grid AS $r){
                        ?><option value="<?=$r['rol_id']?>"><?=$r['nombre']?></option><?
                    }

                }

                 ?>
                </select>
                
            </div>
            <div class="control-group">
                <div class="controls">
                  
                    <button type="submit" disabled="disabled" id="submitButton" class="btn">Agregar</button>
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


