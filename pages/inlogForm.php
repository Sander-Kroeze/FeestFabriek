<?php

include('login.php');
include_once("DBconfig.php");

if (isset($_POST["submit"])) {
    $error = "";
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    try {
        $sql = "SELECT * FROM medewerker WHERE email = ?";
        $stmt = $db->prepare($sql); $stmt->execute(array($email));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $hash = $result["Wachtwoord"];
            if (password_verify($password, $hash)) {
                $mijnSession = session_id();
                $_SESSION["ID"] = $mijnSession;
                $_SESSION["USER"] = $result["Naam"];
                $_SESSION["EMAIL"] = $result["Email"];
                $_SESSION["PASSWORD"] = $result["Wachtwoord"];
                $_SESSION["test"] = 1;

                echo "
          <script>location.href='index.php?page=formAdminPagina';</script>
        ";
            } else {
                $error.= "Inloggegevens ongeldig<br>";
            }
        }else {
            $error.= "Inloggegevens ongeldig<br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    echo "<div id='meldingen'>". $error . "</div>";
}
?>
