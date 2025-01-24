<?php
require_once 'db_connectie.php';
$db = maakVerbinding();

//Check welke order ID
$orderid = $_GET['orderId'];

//Krijg data van dat order ID
$sql = 'SELECT [status] FROM [pizza_order] WHERE order_id = :orderid';
$query = $db->prepare($sql);

$data_array = [
    ':orderid' => htmlspecialchars($orderid)
];
$query->execute($data_array);
$orderInfo = $query->fetch();

if ($orderInfo['status'] == 1) {
    $status = 'In keuken';
} else if ($orderInfo['status'] == 2) {
    $status = 'In bezorging';
} else if ($orderInfo['status'] == 3) {
    $status = 'Afgeleverd';
}

$sql = 'SELECT [product_name], [quantity] FROM [pizza_order_product] WHERE order_id = :orderid';
$query = $db->prepare($sql);

$data_array = [
    ':orderid' => htmlspecialchars($orderid)
];
$query->execute($data_array);
$orderItems = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bestellingen</title>
</head>

<body>
    <header>
        <a href="user.php"><img src="img/user.png" alt="Gebruiker"></a>
        <img src="img/logo.png" alt="Logo">
        <a href="cart.php"><img src="img/cart.png" alt="Winkelmandje"></a>
    </header>
    <nav>
        <a href="index.php">
            <p>Home</p>
        </a>
        <a href="pizza.php">
            <p>Pizza</p>
        </a>
        <a href="overig.php">
            <p>Overig</p>
        </a>
        <a href="about.php">
            <p>Over Ons</p>
        </a>
    </nav>
    <main>
        <section class="cart">
            <?php
            //Toon order
            echo '<h3>' . 'Bestelling #' . $orderid . '</h3><br>';
            echo '<h3>' . 'Status: ' . $status . '</h3>';
            echo '<table>
                <tr>
                    <th>Product:</th>
                    <th>Aantal:</th>
                </tr>';
            foreach ($orderItems as $item) {
                echo '<tr><td>' . $item['product_name'] . '</td>';
                echo '<td>' . $item['quantity'] . '</td></tr>';
            }
            echo '</table>';
            ?>
        </section>
    </main>
</body>

</html>