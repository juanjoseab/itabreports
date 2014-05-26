<?php
if ($this->acl->acl("Submision")) {
    MasterController::requerirModelo("medicion_blh_info");
    $vinfo = new medicion_blh_info();
    $infoData = $vinfo->getList(array(), Array("hospital_id" => Array($_GET['hid'], "=")));
    $info = $infoData[0];
    MasterController::requerirModelo("hospital");
    $hospital = new hospital();
    $hospital->setHospitalId($_GET['hid']);
    $hospital->getValuesBySetedId();


    MasterController::requerirModelo("profesion_coordinadora_blh");
    $prc = new profesion_coordinadora_blh();
    $profs = $prc->getList(Array(), array());
    ?>






    <form class="form-horizontal" id="infoBasica">

        <fieldset>

            <input type="hidden" name="hospital_id" value="<?= $hospital->getHospitalId() ?>">
            <?php
            if ($info['medicion_blh_info_id']) {
                ?>
                <input type="hidden" name="medicion_blh_info_id" value="<?= $info['medicion_blh_info_id'] ?>">
                <?php
            } else {
                ?>
                <input type="hidden" name="isnew" value="isnew">
                <?php
            }
            ?>

            <div class="control-group">
                <label class="control-label" >Inauguración</label>
                <div class="controls">
                    <input type="text" 
                           class="signedField notNulleable datepicker" 
                           required="required"  
                           placeholder="Inauguracion"
                           id="Inauguracion"
                           name="inauguracion" 
                           value="<?= $info['inauguracion'] ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" >Fecha de primera pasteurización</label>
                <div class="controls">
                    <input type="text" 
                           class="signedField notNulleable datepicker" 
                           required="required"  
                           placeholder="Fecha de primera pasteurizacion"
                           id="Fecha_primera_pasteurizacion"
                           name="fecha_primera_pasteurizacion" 
                           value="<?= $info['fecha_primera_pasteurizacion'] ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" >Cantidad de cunas en servicio de recien nacido</label>
                <div class="controls">
                    <input type="text" class=" intField signedField notNulleable" maxsize=""  
                           required="required"  
                           placeholder="Cantidad Cunas Servicio Recien Nacido"  
                           id="Cantidad Cunas Servicio Recien Nacido"  
                           name="cantidad_cunas_servicio_recien_nacido" 
                           value="<?= $info['cantidad_cunas_servicio_recien_nacido'] ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" >Cantidad de camas en maternidad</label>
                <div class="controls">
                    <input type="text" class=" intField signedField notNulleable" maxsize=""  
                           required="required"  placeholder="Cantidad Camas Maternidad"  
                           id="Cantidad Camas Maternidad"  name="cantidad_camas_maternidad" 
                           value="<?= $info['cantidad_camas_maternidad'] ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" >Días a la semana que se pauteuriza</label>
                <div class="controls">
                    <input type="text" class=" intField signedField notNulleable" maxsize=""  
                           required="required"  placeholder="Días a la semana que se pauteuriza"  
                           id="dias_pasteurizacion_semanal"  name="dias_pasteurizacion_semanal" 
                           value="<?= $info['dias_pasteurizacion_semanal'] ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" >Veces al día que se pauteuriza</label>
                <div class="controls">
                    <input type="text" class=" intField signedField notNulleable" maxsize=""  
                           required="required"  placeholder="Veces al dia que se pauteuriza"  
                           id="veces_pasteurizacion_diaria"  name="veces_pasteurizacion_diaria" 
                           value="<?= $info['veces_pasteurizacion_diaria'] ?>" />
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" >Nombre de la coordinadora</label>
                <div class="controls">
                    <input type="text" class=" stringField signedField notNulleable" 
                           maxsize=""  required="required"  placeholder="Nombre Coordinadora"  
                           id="Nombre Coordinadora"  name="nombre_coordinadora" 
                           value="<?= $info['nombre_coordinadora'] ?>" />
                </div>
            </div><div class="control-group">
                <label class="control-label" >Profesión de la coordinadora</label>
                <div class="controls">
                    <select name="profesion_coordinadora_blh_id">
                        <?php
                        foreach ($profs AS $prfs) {
                            ?> <option 
                            <?php
                            if ($info['profesion_coordinadora_blh_id'] == $prfs['profesion_coordinadora_blh_id']) {
                                ?>selected="selected" <?
                                }
                                ?>
                                value="<?= $prfs['profesion_coordinadora_blh_id'] ?>"><?= $prfs['profesion'] ?></option> <?php
                            }
                            ?>
                    </select>
                </div>
            </div><div class="control-group">
                <label class="control-label" >Teléfono</label>
                <div class="controls">
                    <textarea class=" textField signedField Nulleable"  placeholder="Telefono"  id="Telefono"  name="telefono" ><?= $info['telefono'] ?></textarea>
                </div>
            </div><div class="control-group">
                <label class="control-label" >Email contacto</label>
                <div class="controls">
                    <textarea class=" textField signedField Nulleable"  
                              placeholder="Email de contacto"  
                              id="EmailContacto"  name="email_contacto" ><?= $info['email_contacto'] ?></textarea>
                </div>
            </div><div class="control-group">
                <div class="controls">

                    <button type="button" class="btn" id="sbmt">Guardar</button>
                </div>
            </div>
        </fieldset>
    </form>

    <?php
    /* echo $vinfo->constructForm(
      "infoBasica",
      $this->createLink("medicionblh", "saveInfoBasica", "idh=". $_GET['itemId']),
      "",
      "POST",
      "Guardar"); */
    ?>





    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Respuesta</h3>
        </div>
        <div class="modal-body" id="modalBodyP">

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>            
        </div>
    </div>

<? } else { ?>
    <div class="span6">
        <div class="alert alert-block">

            <h4>Acceso no permitido!</h4>
            No tiene suficientes privilegios en el sistema para poder agregar datos.
        </div>
    </div>


<?php } ?>




