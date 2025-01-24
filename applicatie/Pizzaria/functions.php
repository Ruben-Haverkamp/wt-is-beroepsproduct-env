<?php
//Controleer of gebruiker personeel is
function isPersoneel()
{
    if (isset($_SESSION['gebruiker'])) {
        require_once 'db_connectie.php';
        $db = maakVerbinding();

        $sql = 'SELECT [role] FROM [user] WHERE [username] = :user';
        $query = $db->prepare($sql);

        $data_array = [
            ':user' => htmlspecialchars($_SESSION['gebruiker']),
        ];
        $query->execute($data_array);
        $role = $query->fetch();
        if ($role['role'] == 'Personnel') {
            return true;
        }
    }
    return false;
}

//Voeg pizza toe aan winkelmandje
function toevoegen()
{
    $pizza = $_POST['pizza'];

    $db = maakVerbinding();
    $sql = 'SELECT * FROM [Product] WHERE name = :pizza';
    $query = $db->prepare($sql);
    $query->bindParam(':pizza', $pizza, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            $pizzaExists = false;
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['name'] === $row['name']) {
                    $cartItem['quantity']++;
                    $pizzaExists = true;
                    break;
                }
            }

            if (!$pizzaExists) {
                $pizzaData = [
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => 1
                ];

                $_SESSION['cart'][] = $pizzaData;
            }
        }
    }
}
?>