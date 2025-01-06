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
        <section class="cart">
            <h3>Bestelling #13</h3>
            <table>
                <tr>
                    <th>Beschijving</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Pizza Pepperoni</td>
                    <td>Keuken
                        <button>+</button>
                    </td>
                </tr>
                <tr>
                    <td>Coca Cola</td>
                    <td>Klaar

                        <button>+</button>
                    </td>
                </tr>
            </table>
            <p class="bestellingen">Adres: Klantlaan 37 9277WK Arnhem</p>
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