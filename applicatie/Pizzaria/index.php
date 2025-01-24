<?php
require_once 'db_connectie.php';
require_once 'functions.php';
session_start();

//Voeg pizza toe aan winkelmandje
if (isset($_POST['toevoegen'])) {
    toevoegen();
}
?>

<!DOCTYPE html>
<html lang="nl">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home</title>
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
        <section class="actie">
            <img src="img/actie.png" alt="Gratis verzending op donderdag">
        </section>

        <h2>Acties:</h2>
        <section>
        <article>
                <img src="img/pepperoni.png" alt="Pepperoni">
                <div class="pizzainfo">
                    <h3>Pepperoni</h3>
                    <form method="post" action="">
                        <input type="hidden" name="pizza" value="Pepperoni Pizza">
                        <button type="submit" name="toevoegen">
                            <img src="img/cart.png" alt="Toevoegen aan winkelmandje">
                        </button>
                    </form>
                </div>
            </article>

            <article>
                <img src="img/vegetarisch.png" alt="vegetarisch">
                <div class="pizzainfo">
                    <h3>Vegetarisch</h3>
                    <form method="post" action="">
                        <input type="hidden" name="pizza" value="Vegetarische Pizza">
                        <button type="submit" name="toevoegen">
                            <img src="img/cart.png" alt="Toevoegen aan winkelmandje">
                        </button>
                    </form>
                </div>
            </article>

            <article>
                <img src="img/sprite.png" alt="Sprite">
                <div class="pizzainfo">
                    <h3>Sprite</h3>
                    <form method="post" action="">
                        <input type="hidden" name="pizza" value="Sprite">
                        <button type="submit" name="toevoegen">
                            <img src="img/cart.png" alt="Toevoegen aan winkelmandje">
                        </button>
                    </form>
                </div>
            </article>
        </section>
    </main>
    
    <?php
    //Knop naar personeel pagina
    if (isPersoneel() == true) {echo '<a href="orders.php">Naar bestellingen</a>';};
    ?>
</body>

</html>