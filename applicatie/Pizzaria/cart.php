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
                <tr>
                    <td>Pizza Pepperoni</td>
                    <td>1</td>
                    <td>€13</td>
                    <td>
                        <button>-</button>
                        <button>+</button>
                    </td>
                </tr>
                <tr>
                    <td>Coca Cola</td>
                    <td>1</td>
                    <td>€4</td>
                    <td>
                        <button>-</button>
                        <button>+</button>
                    </td>
                </tr>
                <tr>
                    <th>Totaal:</th>
                    <td>2</td>
                    <th>€17</th>
                    <th></th>
                </tr>
            </table>
        </section>

        <section class="cart">
            <button class="order">Bestel</button>
        </section>


    </main>
</body>

</html>