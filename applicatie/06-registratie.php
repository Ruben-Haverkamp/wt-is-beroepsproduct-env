<?php
require_once 'db_connectie.php';

$melding = '';  // nog niks te melden

// check voor de knop
if(isset($_POST['registeren'])) {
    $fouten = [];
    // 1. inlezen gegevens uit form
    $naam       = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    // 2. controleren van de gegevens
    if(strlen($naam) < 4) {
        $fouten[] = 'Gebruikersnaam minstens 4 karakters.';
    }

    if(strlen($wachtwoord) < 8) {
        $fouten[] = 'Wachtwoord minstens 8 karakters.';
    }

    // 3. opslaan van de gegevens
    if(count($fouten) > 0) {
        $melding = "Er waren fouten in de invoer.<ul>";
        foreach($fouten as $fout) {
            $melding .= "<li>$fout</li>";
        }
        $melding .= "</ul>";

    } else {
        // Hash the password
        $passwordhash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        
        // database
        $db = maakVerbinding();
        // Insert query (prepared statement)
        $sql = 'INSERT INTO Gebruikers(naam, passwordhash)
                values (:naam, :passwordhash)';
        $query = $db->prepare($sql);

        // Send data to database
        $data_array = [
            'naam' => $naam,
            'passwordhash' => $passwordhash
        ];
        $succes = $query->execute($data_array);

        // Check results
        if($succes)
        {
            $melding = 'Gebruiker is geregistreerd.';
        }
        else
        {
            $melding = 'Registratie is mislukt.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
</head>
<body>
    <form method="post" action="">
        <table>
            <tr>
                <td><label for="naam">naam</label></td>
                <td><input type="text" id="naam" name="naam"></td>
            </tr>
            <tr>
                <td><label for="wachtwoord">wachtwoord</label></td>
                <td><input type="password" id="wachtwoord" name="wachtwoord"></td>
                </tr>
            <tr>
                <td> </td>
                <td><input type="submit" name="registeren" value="registreren"></td>
            </tr>
        </table>
    </form>
    <?=$melding?>
</body>
</html>