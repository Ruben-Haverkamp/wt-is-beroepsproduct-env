<?php
session_start();

//Bestelling
if (isset($_POST['bestel']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    require_once 'db_connectie.php';
    if (isset($_SESSION['gebruiker']) && $_SESSION['gebruiker'] != NULL) {
        $db = maakVerbinding();

        $naam = $_SESSION['gebruiker'];
        $sql = 'SELECT [username], [password], [first_name], [last_name], [address] FROM [User] WHERE username = :naam';
        $query = $db->prepare($sql);

        $data_array = [
            ':naam' => htmlspecialchars($naam)
        ];
        $query->execute($data_array);
        $received = $query->fetch();

        $sql = 'INSERT INTO pizza_order (client_username ,client_name, personnel_username, datetime, status, address)
        VALUES (:user, :name, :personnel, :date, :status, :address)';
        $query = $db->prepare($sql);
        $data_array = [
            ':user' => htmlspecialchars($received['username']),
            ':name' => htmlspecialchars($received['first_name']) . ' ' . htmlspecialchars($received['last_name']),
            ':personnel' => 'rdeboer',
            ':date' => (new DateTime())->format('Y-m-d H:i:s.000'),
            ':status' => 1,
            ':address' => htmlspecialchars($received['address'])
        ];
        $query->execute($data_array);
    } else {
        $db = maakVerbinding();

        $sql = 'INSERT INTO pizza_order (client_name, personnel_username, datetime, status, address)
        VALUES (:name, :personnel, :date, :status, :address)';
        $query = $db->prepare($sql);
        $data_array = [
            ':name' => htmlspecialchars($_POST['name']),
            ':personnel' => 'rdeboer',
            ':date' => (new DateTime())->format('Y-m-d H:i:s.000'),
            ':status' => 1,
            ':address' => htmlspecialchars($_POST['address'])
        ];
        $query->execute($data_array);
    }
    $orderId = $db->lastInsertId();
    foreach ($_SESSION['cart'] as $pizza) {
        $sql = 'INSERT INTO pizza_order_product(order_id, product_name, quantity)
                VALUES (:order_id, :product_name, :quantity)';
        $query = $db->prepare($sql);
        $data_array = [
            ':order_id' => htmlspecialchars($orderId),
            ':product_name' => htmlspecialchars($pizza['name']),
            ':quantity' => htmlspecialchars($pizza['quantity'])
        ];
        $query->execute($data_array);
    }
    unset($_SESSION['cart']);
    header('Location: tracking.php?orderId=' . $orderId);
    exit;
}

//Aantal aanpassen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pizzaName']) && isset($_POST['updateQuantity'])) {
        $pizzaName = $_POST['pizzaName'];
        $action = $_POST['updateQuantity'];

        foreach ($_SESSION['cart'] as &$pizza) {
            if ($pizza['name'] === $pizzaName) {
                if ($action === 'increase') {
                    $pizza['quantity']++;
                } elseif ($action === 'decrease' && $pizza['quantity'] > 1) {
                    $pizza['quantity']--;
                } elseif ($action === 'decrease' && $pizza['quantity'] == 1) {

                    foreach ($_SESSION['cart'] as $index => $item) {
                        if ($item['name'] === $pizza['name']) {
                            unset($_SESSION['cart'][$index]);
                        }
                    }
                }
                break;
            }
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Winkelmandje</title>
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
        <h2>Winkelmandje</h2>
        <section class="cart">
            <table>
                <tr>
                    <th>Beschijving</th>
                    <th>Aantal</th>
                    <th>Prijs</th>
                    <th>Wijzigen</th>
                </tr>

                <?php
                //Winkelmandje tonen
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $pizza) {
                        echo '<tr><td>' . $pizza['name'] . '</td>';
                        echo '<td>' . $pizza['quantity'] . '</td>';
                        echo '<td>' . $pizza['price'] * $pizza['quantity'] . '</td>';
                        echo '<td>
                            <form method="POST" action="">
                                <input type="hidden" name="pizzaName" value="' . htmlspecialchars($pizza['name'], ENT_QUOTES, 'UTF-8') . '">
                                <button type="submit" name="updateQuantity" value="decrease">-</button>
                                <button type="submit" name="updateQuantity" value="increase">+</button>
                            </form>
                          </td></tr>';
                    }
                }
                ?>
            </table>
        </section>

        <section class="cart">
            <form method="POST" action="" class="orderform">
                <?php
                if (!isset($_SESSION['gebruiker'])) {
                    echo '<input class="order" type="text" id="name" name="name" placeholder="Naam" required><br>';
                    echo '<input class="order" type="text" id="address" name="address" placeholder="Adres" required><br>';
                }
                ?>
                <button class="order" type="submit" name="bestel">Bestel</button>
            </form>
        </section>


    </main>
</body>

</html>