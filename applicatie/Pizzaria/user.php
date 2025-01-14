<?php
require_once 'db_connectie.php';
session_start();

///////////////////
//   Uitloggen   //
///////////////////
if (isset($_POST['uitlog'])) {
    // Sessie beëindigen
    session_unset();  // Verwijdert alle sessievariabelen
    session_destroy(); // Vernietigt de sessie
    header("Location: index.php"); // Optioneel: doorverwijzen naar de startpagina
    exit;
}

///////////////////
//  Registreren  //
///////////////////
$melding = '';  // nog niks te melden

// check voor de knop
if (isset($_POST['submit'])) {
    $fouten = [];
    // 1. inlezen gegevens uit form
    $naam       = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];
    $voornaam   = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];

    // 2. controleren van de gegevens
    if (strlen($naam) < 4) {
        $fouten[] = 'Gebruikersnaam minstens 4 karakters.';
    }

    if (strlen($voornaam) < 1) {
        $fouten[] = 'Geef voornaam op.';
    }

    if (strlen($achternaam) < 1) {
        $fouten[] = 'Geef achternaam op.';
    }

    if (strlen($wachtwoord) < 8) {
        $fouten[] = 'Wachtwoord minstens 8 karakters.';
    }

    // 3. opslaan van de gegevens
    if (count($fouten) > 0) {
        $melding = "Er waren fouten in de invoer.<ul>";
        foreach ($fouten as $fout) {
            $melding .= "<li>$fout</li>";
        }
        $melding .= "</ul>";

    } else {
        // Hash het wachtwoord
        $passwordhash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        
        // database
        $db = maakVerbinding();
        // Insert query (prepared statement)
        $sql = 'INSERT INTO [User](username, password, first_name, last_name, role)
        VALUES (:naam, :passwordhash, :first_name, :last_name, :role)';
        $query = $db->prepare($sql);

        // Data array met juiste keys
        $data_array = [
            ':naam' => $naam,
            ':passwordhash' => $passwordhash,
            ':first_name' => $voornaam,
            ':last_name' => $achternaam,
            ':role' => 'Client'
        ];        
        $succes = $query->execute($data_array);

        // Check resultaten
        if ($succes) {
            $melding = 'Gebruiker is geregistreerd.';
        } else {
            $melding = 'Registratie is mislukt.';
        }
    }
}

//////////////////
//   Inloggen   //
//////////////////
$success = '';  // Nog niks te melden 

if (isset($_POST['login'])) {
    // 1. Lees gegevens
    $naam        = $_POST['innaam'];
    $wachtwoord  = $_POST['inwachtwoord'];

    // 3. Ophalen van de hash uit de database
    $db = maakVerbinding();
    // Select query (prepared statement)
    $sql = 'SELECT password FROM [User] WHERE username = :naam';
    $query = $db->prepare($sql);

    $data_array = [
        ':naam' => $naam
    ];
    $query->execute($data_array);

    if ($rij = $query->fetch()) {
        // Gebruiker gevonden
        $passwordhash = $rij['password'];

        // Wachtwoord checken
        if (password_verify($wachtwoord, $passwordhash)) {

            $_SESSION['gebruiker'] = $naam;
            $success = 'Gebruiker is ingelogd.';
        } else {
            $success = 'Fout: onjuiste inloggegevens!';
        }
    } else {
        $success = 'Onjuiste inloggegevens.';
    }
}
?>


<!DOCTYPE html>
<html lang="nl">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlog</title>
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
        <a href="about.html">
            <p>Over Ons</p>
        </a>
    </nav>
    <main class="user">
    <?php if (isset($_SESSION['gebruiker'])): ?>


        
            <section>
                <h3>Welkom, <?= htmlspecialchars($_SESSION['gebruiker']); ?></h3>
                <p>U bent ingelogd.</p><br>
                <form method="post" action="">
                    <input type="submit" value="Uitloggen" name="uitlog">
                </form>
            </section>
        <?php else: ?>



            <section>
                <form method="post" action="">
                    <h3>Inloggen:</h3>
                    <label for="innaam">Gebruikersnaam:</label><br>
                    <input type="text" id="innaam" name="innaam"><br>
                    <label for="inwachtwoord">Wachtwoord:</label><br>
                    <input type="password" id="inwachtwoord" name="inwachtwoord"><br>
                    <input type="submit" value="Inloggen" name="login">
                    <?= $success ?? ''; ?><br>
                </form>
            </section>

            <section>
                <form method="post" action="">
                    <h3>Registreren:</h3>
                    <label for="voornaam">Voornaam:</label><br>
                    <input type="text" id="voornaam" name="voornaam"><br>
                    <label for="achternaam">Achternaam:</label><br>
                    <input type="text" id="achternaam" name="achternaam"><br>
                    <label for="naam">Gebruikersnaam:</label><br>
                    <input type="text" id="naam" name="naam"><br>
                    <label for="wachtwoord">Wachtwoord:</label><br>
                    <input type="password" id="wachtwoord" name="wachtwoord"><br>
                    <input type="submit" name="submit" value="Registreren">
                    <?= $melding ?? ''; ?><br>
                </form>
            </section>
        <?php endif; ?>
    </main>
</body>

</html>