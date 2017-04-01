<table>
    <tr>
        <td>#</td>
    <?php
        foreach ($resultset->dimensión as $label){
           echo '<td>'. $label .'</td>'; 
        }
    ?>
    </tr>
    <?php
        $cont = 0;
        foreach ($resultset->reporte as $serie => $valores){
            echo '</tr>';
                echo '<td>'.$nombres_series[$cont++].'</td>';
                foreach($valores as $valor){
                    echo '<td>'.$valor.'</td>';
                }
            echo '</tr>';
        }
    ?>
</table>




