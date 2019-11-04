<?php
include('aanmelden.php');
// dikke br's
echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";

// checked als submit is geset
if (isset($_POST["submit"])) {


    // Lees de velden uit de form en controleerd ze op speciale tekens
    $voornaam   = htmlspecialchars($_POST["voornaam"]);
    $email      = htmlspecialchars($_POST["email"]);
    $password   = htmlspecialchars($_POST["password"]);

    // Controleer formaat van het emailadres
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<pre id='error'>$email is een goed email adres</pre>";
    } else {
        echo "<pre id='error'>$email is een ongeldige email is niet geldig</pre>";
        exit;
    }

    // Lees wachtwoord in en maak hash
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // controleerd of de recaptcha response leeg is of nog en of die is geset.
    if (isset($_POST["g-recaptcha-response"]) && empty($_POST["g-recaptcha-response"])) {
        echo 'Bent u een robot??!';
        exit;
    }


    // zoek of email bestaat in de database
    $sql  = "SELECT email FROM medewerker WHERE email = '$email'";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        $email
    ));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "<script type='text/javascript'>alert('het email adres: $email, bestaat al!');</script>";
        // echo "<script> location.href='http://localhost/School/Leer%20Jaar_2_(2018-2019)/BEP/302/webshop/index.php?page=aanmelden'; </script>";
        exit;
    }

    else {
        // emailadres bestaat nog niet, dus we maken een INSERT-query om de gegevens in de DB te zetten.
        $query = "INSERT INTO medewerker (Naam, Email, Wachtwoord)  VALUES ('$voornaam', '$email', '$hashedPassword')";
        $db->exec($query);
        // echo "<script type='text/javascript'>alert('het email aders: $email, bestaat al.');</script>";
    }
}
// catch(PDOException $e) {
//   echo ("<script>alert('Account NIET aangemaakt.');location.href='index.php?page=inloggen';</script>");
// }
// }
// }
?>
