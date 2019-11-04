<?php

include("adminPagina.php");

if (isset($_POST["submit_lijst"])) {

} else if (isset($_POST["submit_korting"])) {

//  haalt gegevens van de form op  ----------------------------------------------------------->
    $email = htmlspecialchars($_POST["email"]);
    $korting = htmlspecialchars($_POST["korting"]);

//  controleerd of het mailadres goed is ----------------------------------------------------------->
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

    } else {

//      redirect je terug naar de admin pagina met een alert ----------------------------------------------------------->
        echo '
            <script>
            alert("de email is niet goed \n U wordt terug gestuurd.");
            location.href=\'index.php?page=formAdminPagina\';
            </script>
            '
        ;
        exit;
    }

    $koring_berekenen = $korting % 5;

//  kijkt of de korting deelbaar is door 5, of het hoger is dan 0 en lager is dan 101 ----------------------------------------------------------->
    if ($korting % 5 == 0 && $korting >= 0 && $korting <= 101) {
    //  zoek of email bestaat in de database ----------------------------------------------------------->
        $sql  = "SELECT Email FROM klant WHERE Email = '$email'";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            $email
        ));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //  als er resultaat is dan ----------------------------------------------------------->
        if ($result) {

        //  zet de bestanden in de database ----------------------------------------------------------->
            $query_korting = "UPDATE klant SET Korting = '$korting' WHERE Email = '$email'";
            $db->exec($query_korting);

        //  redirect je naar de admin pagina ----------------------------------------------------------->
            echo "
            <script>
            alert('U heeft de korting toegekend aan de email: $email');
            location.href='index.php?page=formAdminPagina';
              </script>
         "
            ;
        } else {

        //  redirect je naar de admin pagina ----------------------------------------------------------->
            echo "
            <script>
            alert('Het mail adres is niet bij ons bekend!');
            location.href='index.php?page=formAdminPagina';
              </script>
         "
            ;
        }

    } else {

    //  redirect je naar de admin pagina ----------------------------------------------------------->
        echo '
            <script>
            alert("De korting moet met een veelfout van 5 gegeven worden \n U wordt terug gestuurd.");
            location.href=\'index.php?page=formAdminPagina\';
            </script>
            '
        ;
        exit;
    }
}


