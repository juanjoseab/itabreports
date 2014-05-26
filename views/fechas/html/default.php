<div class="span9">
    <h2>Listado de fechas <small>para ingreso de datos</small></h2>

    <?php
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>


    <? $this->createGrid(false); ?>


    <table class="table table-hover" id="waza">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>


        <?
        if (count($this->grid) > 0) {
            foreach ($this->grid AS $row => $r) {
                ?>
                <tr>
                    <td><?= $r['fecha_id'] ?></td>
                    <td><?= $this->monthName($r['mes']) ?>, <?= $r['anio'] ?></td>
                    <td>
                        <? if ($r['estado'] == 1) { ?>
                            <span class="label label-success">Activa</span>
                        <? } else { ?>
                            <span class="label label-important">Inactiva</span>
                        <? } ?>

                    </td>
                    <td>
                        <div class="btn-group">





                            <? if ($this->acl->acl("Modificar")) { ?>
                                <a data-toggle="tooltip" 
                                   title="Editar fecha" 
                                   class="btn btn-info" 
                                   href="?v=fechas&action=viewUpdateForm&itemId=<?= $r['fecha_id'] ?>">
                                    <i class="icon icon-pencil icon-white"></i>

                                </a>


                                <? if ($r['estado'] == 1) { ?>
                                    <a data-toggle="tooltip" 
                                       title="Inactivar" 
                                       class="btn btn-inverse" 
                                       href="?v=fechas&action=block&itemId=<?= $r['fecha_id'] ?>">
                                        <i class="icon icon-stop icon-white"></i>

                                    </a>
                                <? } else { ?>
                                    <a data-toggle="tooltip" 
                                       title="Activar" 
                                       class="btn btn-success" 
                                       href="?v=fechas&action=unblock&itemId=<?= $r['fecha_id'] ?>">
                                        <i class="icon icon-play icon-white"></i>

                                    </a>
                                <? } ?>
                            <? } ?>

                            <? if ($this->acl->acl("Eliminar")) { ?>
                                <a  data-toggle="tooltip" 
                                    title="Elimiar fecha" 
                                    accesskey=""
                                    class="btn btn-warning needAlertConfirm" 
                                    href="?v=fechas&action=delete&itemId=<?= $r['fecha_id'] ?>">
                                    <i class="icon icon-remove icon-white"></i>

                                </a>
                            <? } ?>


                        </div>

                    </td>
                </tr>
                <?
            }
        }
        ?>
    </table>
    <?
    $pags = $this->getArrayPaginacion();
    if ($_GET['pag'] == 0 || !$_GET['pag']) {
        $pageActive = 0;
    } else {
        $pageActive = $_GET['pag'];
    }
    ?> 
    <div class="pagination">
        <ul>
            <?php
            if (count($pags) == 1) {
                ?>
                <li class="active"><a href="#">1</a></li>
                    <?
                } else {
                    foreach ($pags as $pag) {
                        ?>
                    <li <?php
                    if ($pag == $pageActive) {
                        echo 'class="active"';
                    }
                    ?>><a href="?v=das&pag=<?= $pag ?>"><?= ($pag + 1) ?></a></li>
                        <?
                    }
                }
                ?>
        </ul>
    </div>


</div>
<script type="text/javascript" src="<?= $this->templateUrl() ?>/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('table#waza a.btn').tooltip({
            trigger: 'hover',
            animation: true,
            placement: 'top'
        });
    });
</script>

