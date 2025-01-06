<?php

require_once 'db_connectie.php';

// Use isset() to check if the form values exist
$componistId    = isset($_POST['componistId']) ? $_POST['componistId'] : null;
$naam           = isset($_POST['naam']) ? $_POST['naam'] : '';
$geboortedatum  = isset($_POST['geboortedatum']) ? $_POST['geboortedatum'] : null;
$schoolId       = isset($_POST['schoolId']) ? $_POST['schoolId'] : null;

if (empty($geboortedatum)) {
    $geboortedatum = null;
}
if (empty($schoolId)) {
    $schoolId = null;
}

$db = maakVerbinding();
// Insert query without componistId
$sql = 'INSERT INTO componist (naam, geboortedatum, schoolId)
        VALUES (:naam, :geboortedatum, :schoolId);'; 
$query = $db->prepare($sql);

$data_array = [
    'naam' => $naam,
    'geboortedatum' => $geboortedatum,
    'schoolId' => $schoolId
];

$succes = $query->execute($data_array);

if ($succes) {
    $melding = 'Gegevens zijn opgeslagen in de database.';
} else {
    $melding = 'Er ging iets fout bij het opslaan.';
}

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Componinst - nieuw</title>
    <link href="css/normalize.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <form action="01-componist-new.php" method="post">
        <label for="naam">naam</label>
        <input type="text" id="naam" name="naam"><br>

        <label for="geboortedatum">geboortedatum</label>
        <input type="date" id="geboortedatum" name="geboortedatum"><br>

        <label for="schoolId">schoolId</label>
        <input type="text" id="schoolId" name="schoolId"><br>

        <input type="reset" id="reset" name="reset" value="wissen">
        <input type="submit" id="opslaan" name="opslaan" value="opslaan">    
    </form>
</body>

</html>
