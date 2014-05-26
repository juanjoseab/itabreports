<?php
if ($this->acl->haveAccess()) {
    $alerts = $this->activesMsgs();
    if ($alerts) {
        echo $alerts;
    }
    ?>


    <table class="table table-responsive table-condensed table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Path</th>                        
                <th>Visible</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
//$this->_pre($this->params['modulesTree']);
            $tree = $this->params['modulesTree'];
            foreach ($tree AS $module) {
                ?>
                <tr>                    
                    <td><b><?= $module['parent']['name'] ?></b></td>
                    <td><b><?= $module['parent']['path'] ?></b></td>

                    <td><?= ($module['parent']['visible'] == 1) ? "visible" : "no visible" ?></td>
                    <td>
                        <a title="Editar modulo" href="?v=modules&action=viewModuleEditionForm&mid=<?= $module['parent']['id_module'] ?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                        <a title="Eliminar modulo" href="?v=modules&action=deleteRequest&mid=<?= $module['parent']['id_module'] ?>" ><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>

                <?php
                if (count($module['childrens']) > 0) {
                    foreach ($module['childrens'] AS $child) {
                        ?>

                        <tr>
                    
                            <td> &nbsp;&nbsp;- <?= $child['name'] ?></td>
                            <td><?= $child['path'] ?></td>

                            <td><?= ($child['visible'] == 1) ? "visible" : "no visible" ?></td>
                            <td>
                                <a title="Editar modulo" href="?v=modules&action=viewModuleEditionForm&mid=<?= $child['id_module'] ?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                                <a title="Eliminar modulo" href="?v=modules&action=deleteRequest&mid=<?= $child['id_module'] ?>" ><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>


                        <?php
                    }
                }
                ?>

                <?php
            }
            ?>
        </tbody>
    </table>





<?php } ?>
