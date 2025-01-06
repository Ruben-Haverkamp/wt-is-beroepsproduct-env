<?php
require_once 'db_connectie.php'; // Databaseverbinding

// Initialisatie
$fouten = [];
$melding = '';

// Check of het formulier is verstuurd
if (isset($_POST['opslaan'])) {
    // Variabelen uit POST halen
    $componistId    = $_POST['componistId'] ?? null;
    $naam           = $_POST['naam'] ?? null;
    $geboortedatum  = $_POST['geboortedatum'] ?? null;
    $schoolId       = $_POST['schoolId'] ?? null;

    // Controles op verplichte velden
    if (empty($componistId)) {
        $fouten[] = 'ComponistId is verplicht om in te vullen.';
    } elseif (!is_numeric($componistId)) {
        $fouten[] = 'ComponistId moet een numerieke waarde zijn.';
    }

    if (empty($naam)) {
        $fouten[] = 'Naam is verplicht om in te vullen.';
    }

    // Niet-verplichte velden: zet op NULL indien leeg
    if (empty($geboortedatum)) {
        $geboortedatum = null;
    }

    if (empty($schoolId)) {
        $schoolId = null;
    }

    // Bij geen fouten: opslaan in de database
    if (count($fouten) === 0) {
        try {
            $db = maakVerbinding(); // Ophalen databaseverbinding

            // Query voorbereiden
            $query = $db->prepare("
                INSERT INTO componist (componistId, naam, geboortedatum, schoolId)
                VALUES (:componistId, :naam, :geboortedatum, :schoolId)
            ");

            // Data binden en query uitvoeren
            $succes = $query->execute([
                ':componistId' => $componistId,
                ':naam' => $naam,
                ':geboortedatum' => $geboortedatum,
                ':schoolId' => $schoolId
            ]);

            if ($succes) {
                $melding = 'Gegevens zijn opgeslagen in de database.';
                // Variabelen legen
                $componistId = $naam = $geboortedatum = $schoolId = null;
            } else {
                $melding = 'Er ging iets fout bij het opslaan.';
            }
        } catch (Exception $e) {
            $melding = 'Fout: ' . $e->getMessage();
        }
    } else {
        // Fouten weergeven
        $melding = '<ul class="error">';
        foreach ($fouten as $fout) {
            $melding .= '<li>' . htmlspecialchars($fout) . '</li>';
        }
        $melding .= '</ul>';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Componist Toevoegen</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Componist Toevoegen</h1>

    <?php if (!empty($melding)): ?>
        <div><?php echo $melding; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="componistId">Componist ID (verplicht):</label>
        <input type="text" name="componistId" id="componistId" value="<?php echo htmlspecialchars($componistId ?? ''); ?>" required><br>

        <label for="naam">Naam (verplicht):</label>
        <input type="text" name="naam" id="naam" value="<?php echo htmlspecialchars($naam ?? ''); ?>" required><br>

        <label for="geboortedatum">Geboortedatum (optioneel):</label>
        <input type="date" name="geboortedatum" id="geboortedatum" value="<?php echo htmlspecialchars($geboortedatum ?? ''); ?>"><br>

        <label for="schoolId">School ID (optioneel):</label>
        <input type="text" name="schoolId" id="schoolId" value="<?php echo htmlspecialchars($schoolId ?? ''); ?>"><br>

        <button type="submit" name="opslaan">Opslaan</button>
    </form>
</body>
</html>
