<?php
session_start();
require_once 'db_connectie.php';
require_once 'functions.php';
$db = maakVerbinding();

//Check of gebruiker personeel is
if (isPersoneel() == false) {
    exit('Niet gemachtigt');
}

//Pas status aan
if (isset($_POST['status'])) {
    $sql = 'SELECT [status] FROM [pizza_order] WHERE [order_id] = :order';
    $query = $db->prepare($sql);

    $data_array = [
        ':order' => htmlspecialchars($_POST['order']),
    ];
    $query->execute($data_array);
    $curStatus = $query->fetch();
    if ($curStatus['status'] < 3) {
        $newStatus = $curStatus['status'] + 1;

        $sql = 'UPDATE [pizza_order] SET [status] = :status WHERE [order_id] = :order';
        $query = $db->prepare($sql);

        $data_array = [
            ':order' => htmlspecialchars($_POST['order']),
            ':status' => htmlspecialchars($newStatus)
        ];
        $query->execute($data_array);
    }
}

//Krijg alle orders
$sql = 'SELECT [order_id], [address], [client_name], [status] FROM [pizza_order] ORDER BY [order_id] desc';
$query = $db->prepare($sql);

$data_array = [];
$query->execute($data_array);
$orderInfo = $query->fetchAll();
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
        <h2>Bestellingen</h2>

        <?php
        //Toon alle orders
        foreach ($orderInfo as $order) {
            if ($order['status'] == 1) {
                $status = 'In keuken';
            } else if ($order['status'] == 2) {
                $status = 'In bezorging';
            } else if ($order['status'] == 3) {
                $status = 'Afgeleverd';
            }

            $sql = 'SELECT [product_name], [quantity] FROM [pizza_order_product] WHERE order_id = :orderid';
            $query = $db->prepare($sql);

            $data_array = [
                ':orderid' => $order['order_id']
            ];
            $query->execute($data_array);
            $orderItems = $query->fetchAll(PDO::FETCH_ASSOC);

            echo '<section class="cart"><h3>Bestelling #' . $order['order_id'] . '<form method="POST" action="">
            <input type="hidden" name="order" value="' . $order['order_id'] .
                '"><button type="submit" name="status">+</button>
            </form></h3>';
            echo '<table><tr><th>Product</th><th>Aantal</th></tr>';

            foreach ($orderItems as $item) {
                echo '<tr><td>' . $item['product_name'] . '</td>';
                echo '<td>' . $item['quantity'] . '</td></tr>';
            }

            echo '</table><p class="bestellingen">Status: ' . $status . ' <br> Naam: ' . $order['client_name'] . '<br> Adres: ' . $order['address'] . '</p></section>';
        }
        ?>

        <section class="cart">
            <h3>Bestelling #13</h3>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Aantal</th>
                </tr>
                <tr>
                    <td>Pizza Pepperoni</td>
                    <td>2
                    </td>
                </tr>
                <tr>
                    <td>Coca Cola</td>
                    <td>1
                    </td>
                </tr>
            </table>
            <p class="bestellingen">Status: In afwachting
                <button>+</button><br>
                Naam: idk<br>
                Adres: Klantlaan 37 9277WK Arnhem
            </p>
        </section>

        <section class="cart">
            <h3>Bestelling #15</h3>
            <table>
                <tr>
                    <th>Beschijving</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Pizza Pepperoni</td>
                    <td>Afwachting
                        <button>+</button>
                    </td>
                </tr>
                <tr>
                    <td>Lava Cake</td>
                    <td>Keuken
                        <button>+</button>
                    </td>
                </tr>
            </table>
            <p class="bestellingen">Adres: Klantlaan 27 9278WK Arnhem</p>
        </section>
    </main>
</body>

</html>