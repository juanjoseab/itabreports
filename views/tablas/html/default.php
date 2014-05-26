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
                
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
//$this->_pre($this->params['modulesTree']);
            $list = $this->params['list'];
            foreach ($list AS $item) {
                ?>
                <tr>                    
                    <td><b><?= $item['name'] ?></b></td>
                

                    <td><?= ($item['status'] == 1) ? "visible" : "no visible" ?></td>
                    <td>
                        <a title="Editar modulo" href="?v=modules&action=viewModuleEditionForm&mid=<?= $module['parent']['id_module'] ?>" ><span class="glyphicon glyphicon-pencil"></span></a>
                        <a title="Eliminar modulo" href="?v=modules&action=deleteRequest&mid=<?= $module['parent']['id_module'] ?>" ><span class="glyphicon glyphicon-remove"></span></a>
                    </td>
                </tr>

                

                <?php
            }
            ?>
        </tbody>
    </table>





<?php } ?>
