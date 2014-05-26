<?php
@header('Content-Type: text/html; charset=UTF-8');
if ($this->acl->acl("Modificar")) {
    MasterController::requerirModelo("hospital");
    MasterController::requerirModelo("municipio");
    $item = new hospital();
    $item->setHospitalId($_GET['itemId']);
    $item->getValuesBySetedId();

    $mun = new municipio();
    $mun->setMunicipioId($item->getMunicipioId());
    $mun->getValuesBySetedId();
    ?>
    <div class="span9">

        <h1>Editar Hospital</h1>
        <p>
            Llene los campos que aparecen abajo, <span class="label label-important">los campos <strong>Nombre</strong> y <strong>Estado</strong> son obligatorios</span>
        </p>
    <?php
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>

        <form  method="post" action="?v=hospital&action=update" class="form-horizontal" accept-charset="UTF-8" > 
            <div class="control-group">
                <label class="control-label" >ID:</label>        

                <div class="controls">
                    <span class="input-small uneditable-input"><?php echo $item->hospital_id['val'] ?></span>
                    <input type="hidden" class="input-small" name="hospital_id" value="<?php echo $item->getHospitalId() ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" ><span class="text-warning">*</span> Nombre:</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="nombre" value="<?php echo $item->getNombre() ?>" placeholder="Nombre del hospital" />
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" ><span class="text-warning">*</span> Departamento:</label>
                <div class="controls">
                    <select name="departamento_id" id="depSelect">                        
                        <?php
                        $deptolist = $this->getDeptos();
                        foreach ($deptolist AS $dpt) {
                            ?>
                            <option 
                                <?php
                                if($mun->getDepartamentoId() == $dpt['departamento_id']){
                                    ?> selected="selected" <?php
                                }
                                ?>
                                value="<?= $dpt['departamento_id'] ?>"><?= $dpt['nombre'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>



            <div class="control-group">
                <label class="control-label" ><span class="text-warning">*</span> Departamento:</label>
                <div class="controls">
                    <select name="municipio_id" id="munSelect">                        
                        <?php
                        $munilist = $this->getMunicipios($mun->getDepartamentoId(),false);
                        foreach ($munilist AS $mn) {
                            ?>
                            <option 
                                <?php
                                if($mun->getMunicipioId() == $mn['municipio_id']){
                                    ?> selected="selected" <?php
                                }
                                ?>
                                value="<?= $mn['municipio_id'] ?>"><?= $mn['nombre'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">

                    <button type="submit" class="btn">Editar</button>
                </div>
            </div>



        </form>

    </div>

<? } else { ?>
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


