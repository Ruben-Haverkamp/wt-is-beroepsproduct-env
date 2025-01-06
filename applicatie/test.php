<?php

require_once 'db_connectie.php';

$db = maakVerbinding();

echo 'gelukt';

$sql = 'SELECT * FROM componist';
$dataset = $db->query($sql);

function toonTabelInhoud($dataset): string
{
    $html = '<table>';
    $html .= '<thead><tr>';
    for ($i = 0; $i < $dataset->columnCount(); $i++) {
        $col = $dataset->getColumnMeta($i);
        $html .= '<th>' . $col['name'] . '</th>';
    }
    $html .= '</tr></thead>';

    $html .= '<tbody>';
    foreach ($dataset as $row) {
        $html .= '<tr>';
        for ($i = 0; $i < count($row) / 2; $i++) {
            $html .= '<td>' . htmlspecialchars($row[$i] ?? '') . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';
    return $html;
}

?>

<body>
    <?php
    echo toonTabelInhoud($dataset);
    ?>
</body>
