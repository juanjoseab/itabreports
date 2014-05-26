<form accept-charset="utf-8" action="?v=user&action=setModules&uid=<?=$_GET['uid']?>" method="post">
    <div class="row">
    
        <?php
//$this->_pre($this->params['modulesTree']);
        $tree = $this->params['modulesTree'];
        foreach ($tree AS $module) {
            ?>
            <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 rel="<?= $module['parent']['id_module'] ?>">
                            <input 
                                type="checkbox" 
                                name="moduleId<?= $module['parent']['id_module'] ?>"
                                value="<?= $module['parent']['id_module'] ?>"
                                <?php if ($module['parent']['checked']) { ?>
                                    checked="checked"
                                <?php } ?>
                                /> 
                                <?= $module['parent']['name'] ?>
                        </h4>

                    </div>
                    <div class="panel-body">



                        <?php
                        if (count($module['childrens']) > 0) {
                            ?>
                            <ul parent-id="<?= $module['parent']['id_module'] ?>">
                                <?php
                                foreach ($module['childrens'] AS $child) {
                                    ?>
                                    <li>
                                        <input 
                                            type="checkbox" 
                                            name="moduleId<?= $child['id_module'] ?>"
                                            value="<?= $child['id_module'] ?>"
                                            <?php if ($child['checked']) { ?>
                                                checked="checked"
                                            <?php } ?>
                                            /> 
                                        <span rel="<?= $child['id_module'] ?>"><?= $child['name'] ?></span>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="clearfix visible-xs"></div>
        
    </div>
    <input type="submit" value="Guardar" class="btn btn-primary btn-lg" />
</form>