<?php
require_once 'db_connectie.php';
session_start();

$db = maakVerbinding();
$sql = 'SELECT * FROM [Product]';  // Puntkomma toegevoegd
$pizzas = $db->query($sql);

// Zorg ervoor dat je de resultaten correct doorloopt of afdrukt
if ($pizzas) {
    while ($pizza = $pizzas->fetch(PDO::FETCH_ASSOC)) {
        echo $pizza['name']; // Vervang 'naam' met de werkelijke kolomnaam
    }
} else {
    echo 'Geen resultaten gevonden.';
}
?>