<div class="span9">
    <h1>Recoleccion de leche</h1>
    <form action="?v=reportesblh&action=viewRecoleccionLeche" method="get">
        <input name="v" value="reportesblh" type="hidden" />
        <input name="action" value="viewRecoleccionLeche" type="hidden" />
        <label>Indique el año a mostrar</label>
        <select name="year" id="anio-prod">
            <option selected="selected">Elija un año</option>
            <?php
            if ($this->data['year'] && is_array($this->data['year'])) {
                foreach ($this->data['year'] AS $year) {
                    ?>
                    <option value="<?= $year ?>"><?= $year ?></option>
                    <?php
                }
            }
            ?>
        </select>

        <label>Indique el mes a mostrar</label>
        <select name="month" id="mes-prod">

        </select>
        <button type="submit">Generar Reporte</button>
    </form>
</div>
<div class="span9">
    <h3>Recolección de leche</h3>
    <div class="span9">
        <div class="span3">
            <table class="table table-condensed table-bordered ">
                <tr>
                    <th>Recolección</th>
                    <th>Volumen (litros)</th>
                    <th>% del Total</th>
                </tr>
                <tr>
                    <th>Intrahospitalaria</th>
                    <td>
                        <?php
                        echo ($this->data['gobal']['parcial']['llri']);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo round((($this->data['gobal']['parcial']['llri']) / ($this->data['gobal']['parcial']['llri'] + $this->data['gobal']['parcial']['llre']) * 100), 2);
                        ?>
                        %
                    </td>
                </tr>
                <tr>
                    <th>Extrahospitalaria</th>
                    <td>
                        <?php
                        echo $this->data['gobal']['parcial']['llre'];
                        ?>
                    </td>
                    <td>
                        <?php
                        echo round(($this->data['gobal']['parcial']['llre'] / ($this->data['gobal']['parcial']['llri'] + $this->data['gobal']['parcial']['llre']) * 100), 2);
                        ?>
                        %
                    </td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>
                        <?php
                        echo $this->data['gobal']['parcial']['llri'] + $this->data['gobal']['parcial']['llre'];
                        ?>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    <hr />


    <?php
    if (is_array($this->data['mensual']) && count($this->data['mensual']) > 0) {
        $filaMes = "<tr><th>Recolección</th>";
        $filaIntra = "<tr><th>Intrahospitalaria</th>";
        $filaExtra = "<tr><th>Extrahospitalaria</th>";
        $filaTotal = "<tr><th>Total</th>";
        $filaIntraTotal = 0;
        $filaExtraTotal = 0;
        $filaTotalTotal = 0;

        foreach ($this->data['mensual'] AS $col) {
            $filaIntraTotal += $col['llri'];
            $filaExtraTotal += $col['llre'];
            $filaTotalTotal += $col['llre'] + $col['llri'];
            $filaMes .= '<th>' . $this->monthName($col['mes']) . "</th>";
            $filaIntra .= '<td>' . $col['llri'] . "</td>";
            $filaExtra .= '<td>' . $col['llre'] . "</td>";
            $filaTotal .= '<td>' . ($col['llre'] + $col['llri']) . "</td>";
        }

        $filaMes .= "<th>Total</hd></tr>";
        $filaIntra .= "<td>{$filaIntraTotal}</td></tr>";
        $filaExtra .= "<td>{$filaExtraTotal}</td></tr>";
        $filaTotal .= "<td>{$filaTotalTotal}</td></tr>";
        ?>


        <h3>Recolección de leche mensual (Volumen en litros)</h3>
        <table class="table table-bordered table-condensed">

            <?php
            echo $filaMes;
            echo $filaIntra;
            echo $filaExtra;
            echo $filaTotal;
            ?>
        </table>

    <?php } ?>
    <hr />
    <?php if(is_array($this->data['porhospital']) && count($this->data['porhospital'])>0) {?>
    <h3>Recolección por hospital (Mensual y acumulado)</h3>
    <table class="table table-bordered table-condensed">
        <tr>
            <th></th>
            <th colspan="3">Recolección mensual</th>
            <th colspan="3">Recolección acumulada</th>            
        </tr>
        
        <tr>
            <th>Hospital</th>
            <th>Intrahospitalaria</th>
            <th>Extrahospitalaria</th>
            <th>Total</th>
            <th>Intrahospitalaria</th>
            <th>Extrahospitalaria</th>
            <th>Total</th>
        </tr>
        <?php
        foreach ($this->data['porhospital'] AS $row){
            ?>
        
        <tr>
            <td><?=$row['nombre']?></td>
            <td><?=$row['llrim']?></td>
            <td><?=$row['llrem']?></td>
            <td><?=$row['llrim'] + $row['llrem']?></td>
            <td><?=$row['llri']?></td>
            <td><?=$row['llre']?></td>
            <td><?=$row['llre'] + $row['llri']?></td>
        </tr>
            <?php
        }
        ?>
        
        
    </table>
    <?php } ?>
</div>



<script type="text/javascript">
    $(function() {
        $("select#anio-prod").change(function() {
            var anio = $(this).val();
            var uri = $(this).parent().attr('action');
            $.ajax({
                url: "?v=reportesblh&action=getProductionMonthsByYear&year=" + anio,
                data: "",
                type: 'GET',
                success: function(res) {
                    console.log(res);
                    $("#mes-prod option").remove();
                    $("#mes-prod").append(res);
                }
            });

        });
    });
</script>


