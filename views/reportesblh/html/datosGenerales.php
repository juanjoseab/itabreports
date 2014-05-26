<?php ?>
<style>
    .smalltable {
        font-size: 12px;
        border-radius: 6px;
    }
    
    .smalltable tr th {
        background: #149bdf;
        color:#ffffff;
    }
    .smalltable tr th:first-child{
        border-radius: 6px 0 0 0;
    }
    
    .smalltable tr th:last-child{
        border-radius: 0 6px 0 0;
    }
    
</style>

<div class="span9">
    <h1>Reporte de datos generales <br /><small>Bancos de Lecha Humana</small></h1>
    <table class="table table-bordered table-condensed table-condensed smalltable">
        <tr>
            <th>Hospital</th>
            <th>Coordinador/a</th>
            <th>Profesión</th>
            <th>Telénfono</th>
            <th>Email</th>
            <th>Camas en RN</th>
            <th>Inauguración</th>
            <th>Primera pasteurización</th>
            <th>Días que pasteuriza a la semana</th>
            <th>Pasteurizaciones diaria</th>
        </tr>
        <?php
        if (is_array($this->grid)) {

            foreach ($this->grid AS $row) {
                ?>
                <tr>
                    <td><?= $row['hospital'] ?></td>
                    <td><?= $row['coordinador'] ?></td>
                    <td><?= $row['profesion'] ?></td>
                    <td><?= $row['telefono'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['camas_rn'] ?></td>
                    <td><?= $this->formatFromMysqlDate($row['inauguracion']) ?></td>
                    <td><?= $this->formatFromMysqlDate($row['primera_pasteurizacion']) ?></td>
                    <td><?= $row['dias_pasteurizacion_semana'] ?></td>
                    <td><?= $row['pasteurizaciones_diarias'] ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>


</div>
