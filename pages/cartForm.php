<?php

include('cart.php');

include('phpFunctions/plaatsOrder.php');

//  functie voor het verwijderen van een product ----------------------------------------------------------->
function verwijder($idProd) {
    unset($_SESSION["cart"][$idProd]);
    echo "
    <script>
    alert('Het product is verwijderd uit je winkelwagen!');
        location.href='index.php?page=cartForm';
      </script>
      ";
}

if (isset($_POST["submit_verwijder"])) {
    $id = htmlspecialchars($_POST["productID"]);
    verwijder($id);
}

if (isset($_POST["aantalVeranderen"])) {

    $arrayID = htmlspecialchars($_POST["arrayID"]);
    $newValue = htmlspecialchars($_POST["newValue"]);

    if ($newValue < 1) {
        verwijder($arrayID);
    } else {
        $_SESSION["cart"][$arrayID]["productQuantity"] = $newValue;
        echo '
        <script>
        alert("Uw prodcut aantal is verhoogd\' \n U wordt door gestuurd naar de winkelwagen");
        location.href=\'index.php?page=cartForm\';
        </script>
        '
        ;
    }
}

if ((isset($_POST["submit_order"]))) {

//  haalt de gegevens uit de form ----------------------------------------------------------->
    $klant_Naam = htmlspecialchars($_POST["Naam"]);
    $klant_Tussenvoegsel = htmlspecialchars($_POST["Tussenvoegsel"]);
    $klant_Achternaam = htmlspecialchars($_POST["Achternaam"]);
    $klant_Aanhef = htmlspecialchars($_POST["Aanhef"]);
    $klant_Straatnaam = htmlspecialchars($_POST["Straatnaam"]);
    $klant_Huisnummer = htmlspecialchars($_POST["Huisnummer"]);
    $klant_Email = htmlspecialchars($_POST["Email"]);
    $klant_Postcode = htmlspecialchars($_POST["Postcode"]);
    $klant_BezorgMethode = htmlspecialchars($_POST["BezorgMethode"]);
    $klant_Telefoonnummer = htmlspecialchars($_POST["Telefoonnummer"]);
    $klant_Land = htmlspecialchars($_POST["Land"]);
    $totaalBedrag = htmlspecialchars($_POST["totaalBedrag"]);
    $totaalCenten = htmlspecialchars($_POST["totaalCenten"]);

//  controleerd het mail adres  ----------------------------------------------------------->

    if (isset($_SESSION["cart"])) {
        if (filter_var($klant_Email, FILTER_VALIDATE_EMAIL)) {

        } else {
            echo "<script type='text/javascript'>alert('$klant_Email is een ongeldige emailadres');</script>";
            exit;
        }
    }

    $controlPostcode = substr(str_replace(' ', '', strtoupper($klant_Postcode)), 0,6);
    if (!preg_match('/\d\d\d\d[A-Z]{2}/', $controlPostcode)) {
        echo
        "
                <script>
                alert('vul een juiste postcode in');
                </script>
                "
        ;
        exit;
    }

//  haalt gegevens uit de databse op basis van het mail adres ----------------------------------------------------------->
    $sql = "SELECT * FROM klant WHERE Email = '$klant_Email'";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        $klant_Email
    ));
    $result_DB_klant = $stmt->fetch(PDO::FETCH_ASSOC);

    $DB_klant = $result_DB_klant["Naam"];
    $DB_Achternaam = $result_DB_klant["Achternaam"];
    $DB_Email = $result_DB_klant["Email"];
    $DB_AdresID = $result_DB_klant["Adres_ID"];
    $DB_klant_ID = $result_DB_klant["ID"];
    $DB_korting = $result_DB_klant["Korting"];

//  zoek of id bestaat in de database ----------------------------------------------------------->
    $sql4 = "SELECT adresID, Adres, Huisnummer, Postcode, Land 
                            FROM adres
                            WHERE (Adres = '$klant_Straatnaam') 
                            AND (Huisnummer = '$klant_Huisnummer')
                            AND (Postcode = '$klant_Postcode') 
                            AND(Land = '$klant_Land')";
    $stmt = $db->prepare($sql4);
    $stmt->execute(array(
    ));
    $result3 = $stmt->fetch(PDO::FETCH_ASSOC);

    $DB_bestaande_adres = $result3["Adres"];
    $DB_bestaande_postcode = $result3["Postcode"];
    $DB_bestaande_huisnr = $result3["Huisnummer"];
    $DB_bestaande_land = $result3["Land"];
    $DB_bestaande_Adres_ID = $result3["adresID"];

//  als er resultaat is voor het vinden van een klant ----------------------------------------------------------->
    if ($result_DB_klant) {
        //  als de DB_klant overeenkomt met de ingevoerde klant info----------------------------------------------------------->
        if ($DB_klant == $klant_Naam && $DB_Achternaam == $klant_Achternaam && $DB_Email == $klant_Email) {
            //  als de ingevoerde adres info niet overeen komen met de al aanwezige info----------------------------------------------------------->
            if ($DB_bestaande_adres == $klant_Straatnaam && $DB_bestaande_postcode == $klant_Postcode && $DB_bestaande_huisnr == $klant_Huisnummer) {

                if ($DB_bestaande_Adres_ID !== $DB_AdresID) {
    //              Update de klant met het nieuwe adres id ----------------------------------------------------------->
                    $query_vervangID = "UPDATE klant SET Adres_ID = '$DB_bestaande_Adres_ID' WHERE Email = '$klant_Email'";
                    $db->exec($query_vervangID);

                    //  Kijkt of de klant korting heeft ----------------------------------------------------------->
                    if ($DB_korting > 0) {
                        $bestellingMetKorting = new plaatsOrder;
                        $bestellingMetKorting->bestellingMetKorting($klant_BezorgMethode, $DB_klant_ID, $DB_bestaande_Adres_ID, $DB_korting, $totaalBedrag);
                    } else {
                        $bestellingMetKorting = new plaatsOrder;
                        $bestellingMetKorting->bestellingZonderKorting($klant_BezorgMethode, $DB_klant_ID, $DB_bestaande_Adres_ID, $totaalBedrag);
                    }
                } else {
                    //  Kijkt of de klant korting heeft ----------------------------------------------------------->
                    if ($DB_korting > 0) {
                        $bestellingMetKorting = new plaatsOrder;
                        $bestellingMetKorting->bestellingMetKorting($klant_BezorgMethode, $DB_klant_ID, $DB_AdresID, $DB_korting, $totaalBedrag);
                    } else {
                        $bestellingMetKorting = new plaatsOrder;
                        $bestellingMetKorting->bestellingZonderKorting($klant_BezorgMethode, $DB_klant_ID, $DB_AdresID, $totaalBedrag);
                    }
                }
            } else {
                $query = "INSERT INTO adres (Adres, Huisnummer, Postcode, Land)  
                          VALUES ('$klant_Straatnaam', '$klant_Huisnummer', '$klant_Postcode', '$klant_Land')";
                $db->exec($query);

        //      pakt het laatste oder id ----------------------------------------------------------->
                $last_adresID = $db->lastInsertId();

//              Update de klant met het nieuwe adres id ----------------------------------------------------------->
                $query_vervangID = "UPDATE klant SET Adres_ID = '$last_adresID' WHERE Email = '$klant_Email'";
                $db->exec($query_vervangID);

            //  Kijkt of de klant korting heeft ----------------------------------------------------------->
                if ($DB_korting > 0) {

        //          maakt een nieuw opject aan ----------------------------------------------------------->
                    $bestellingMetKorting = new plaatsOrder;

        //          geeft gegevens aan de functie in plaatsOrder ----------------------------------------------------------->
                    $bestellingMetKorting->bestellingMetKorting($klant_BezorgMethode, $DB_klant_ID, $last_adresID, $DB_korting, $totaalBedrag);
                } else {

        //          maakt een nieuw opject aan ----------------------------------------------------------->
                    $bestellingMetKorting = new plaatsOrder;

        //          geeft gegevens aan de functie in plaatsOrder ----------------------------------------------------------->
                    $bestellingMetKorting->bestellingZonderKorting($klant_BezorgMethode, $DB_klant_ID, $last_adresID, $totaalBedrag);
                }

                echo
                "
                <script>
                alert('Dit adres Bestond nog niet, nieuw id = $last_adresID');
                </script>
                "
                ;
            }
        }
    } else {
        if ($result3) {

//          maakt een nieuw opject aan ----------------------------------------------------------->
            $bestellingMetKorting = new plaatsOrder;

//          geeft gegevens aan de functie in plaatsOrder ----------------------------------------------------------->
            $bestellingMetKorting->maakNieuweGebruiker($DB_bestaande_Adres_ID, $klant_Naam, $klant_Achternaam, $klant_Tussenvoegsel
                , $klant_Email, $klant_Aanhef, $klant_Telefoonnummer, $klant_BezorgMethode, $totaalBedrag);
        } else {

//          insert adresgegevens naar adres----------------------------------------------------------->
            $query_adres2 = "INSERT INTO adres (Adres, Huisnummer, Postcode, Land)  
            VALUES ('$klant_Straatnaam', '$klant_Huisnummer', '$klant_Postcode', '$klant_Land')";
            $db->exec($query_adres2);

//         pakt het laatste uitgevoerde id----------------------------------------------------------->
            $last_adresID2 = $db->lastInsertId();

//          maakt een nieuw opject aan ----------------------------------------------------------->
            $bestellingMetKorting = new plaatsOrder;

//          geeft gegevens aan de functie in plaatsOrder ----------------------------------------------------------->
            $bestellingMetKorting->maakNieuweGebruiker($last_adresID2, $klant_Naam, $klant_Achternaam, $klant_Tussenvoegsel
                , $klant_Email, $klant_Aanhef, $klant_Telefoonnummer, $klant_BezorgMethode, $totaalBedrag);
        }
    }
}

