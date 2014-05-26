<?php
if ($this->acl->acl("Agregar")) {

    MasterController::requerirModelo('hospital');
    $hosp = new hospital();
    ?>
    <div class="span9">    
        <h3>Agregar hospital</h3>
        <p>
            Llene los campos que aparecen abajo, <span class="label label-important">Todos los campos son obligatorios</span>
        </p>
    <?php
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>

        <form  method="post" action="?v=hospital&action=insert" accept-charset="utf-8">
            <label><span class="text-warning">*</span> Nombre:</label>
            <input type="text" class="input-xxlarge" name="nombre" placeholder="Nombre del hospital" />    <br />
            <label><span class="text-warning">*</span> Departamento:</label>
            <select name="departamento_id" id="depSelect">
                <option value="null">Elija un departamento</option>
                <?php
                $deptolist = $this->getDeptos();
                foreach ($deptolist AS $dpt) {
                    ?>
                    <option value="<?= $dpt['departamento_id'] ?>"><?= $dpt['nombre'] ?></option>
                    <?php
                }
                ?>
            </select><br />
            <label><span class="text-warning">*</span> Municipio:</label>
            <select name="municipio_id" id="munSelect">
                <option value="null">Elija un departamento primero</option>
            </select><br />
            <button type="submit" class="btn">Agregar</button>
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

<script type="text/javascript">
    $(function() {
        $('select#depSelect').change(function() {
            $("select#munSelect option").remove();
            var did = $(this).val();
            if (did != 'null') {
                /*$.ajax({
                 url :      'index.php?v=hospital&action=getMunicipios&did=' + did,
                 data:      '',
                 method:    'GET',
                 success:   function(res){
                 
                 }
                 });*/
                $.getJSON('index.php?v=hospital&action=getMunicipios&did=' + did, function(data) {
                    var items = [];
                    $.each(data, function(key, val) {
                        //console.log(val.nombre);
                        items.push("<option value='" + val.municipio_id + "'>" + val.nombre + "</option>");
                    });
                   
                   var options = items.join("");
                   console.log(options);
                   $("select#munSelect").append(options);
                });
            } else {
                $("select#munSelect").html('<option value="null">Elija un departamento primero</option>');
            }
        });
    });
</script>

