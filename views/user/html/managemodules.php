<form accept-charset="utf-8" action="?v=user&action=setModules&uid=<?= $_GET['uid'] ?>" method="post">
    <input type="submit" value="Guardar" class="btn btn-primary btn-lg" />
    <hr />
    <div class="row">

        <?php
//$this->_pre($this->params['modulesTree']);
        $tree = $this->params['modulesTree'];
        foreach ($tree AS $module) {
            ?>
            <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>
                            <input 
                                rel="<?= $module['parent']['id_module'] ?>"
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
                            <table class="table table-responsive table-condensed"  parent-id="<?= $module['parent']['id_module'] ?>">
                                <?php
                                foreach ($module['childrens'] AS $child) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input
                                                parent-id="<?= $module['parent']['id_module'] ?>"
                                                type="checkbox"
                                                class="child-input"
                                                name="moduleId<?= $child['id_module'] ?>"
                                                value="<?= $child['id_module'] ?>"
                                                <?php if ($child['checked']) { ?>
                                                    checked="checked"
                                                <?php } ?>
                                                /> 

                                        </td>
                                        <td>
                                            <span rel="<?= $child['id_module'] ?>"><?= $child['name'] ?></span>
                                        </td>

                                        <td>
                                            <span><?= ($child['visible']) ? "Visible" : "No visible" ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
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
    <hr />
    <input type="submit" value="Guardar" class="btn btn-primary btn-lg" />
</form>
<script type="text/javascript">
    $(function() {
        $("h4 input").click(function() {
            var relSelector = 'input[parent-id = "' + $(this).attr("rel") + '"]';
            if ($(this).prop('checked')) {
                $(relSelector).prop('checked', true);
            } else {
                $(relSelector).prop('checked', false);
            }
        });

        $("input.child-input").click(function() {
            var relSelector = 'input[rel = "' + $(this).attr("parent-id") + '"]';
            if ($(this).prop('checked')) {
                $(relSelector).prop('checked', true);
            } 
        });
    })
</script>