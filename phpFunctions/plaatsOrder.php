<?php
class plaatsOrder {

//      deze functie plaatsts de bestelling met korting ----------------------------------------------------------->
        public function bestellingMetKorting($bezorgMethode, $klantID, $AdresID, $korting, $prijsTotaal) {

//      hier probeerd hij te connecten met de database
        try {
            $db = new PDO("mysql:host=localhost;dbname=feestfabriek",DB_USER,DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "test";
        }
        $datumNu = date("Y-m-d");

//      Berekent de prijs van de bestelling met korting----------------------------------------------------------->
        $punt = str_replace(',', '.', $prijsTotaal);
        $bereken_korting = $punt / 100;
        $prijsVanKorting = $bereken_korting * $korting;
        if ($bezorgMethode === 'Bezorgen') {
            $plusBezorgKosten = $punt + 50.00;
        } else {
            $plusBezorgKosten = $punt;
        }
        $bereken_korting = $plusBezorgKosten / 100;
        $prijsVanKorting = $bereken_korting * $korting;
        $totaalBedragKorting = $plusBezorgKosten - $prijsVanKorting;
        $totaalRond = number_format($totaalBedragKorting, 2, '.', ',');

//      zet gegevens in orders ----------------------------------------------------------->
        $query = "INSERT INTO orders (Bezorgopties, Orderdatum, BezorgStatus, BetaalStatus, Klant_ID, Adres_ID, totaalPrijs)  
        VALUES ('$bezorgMethode', '$datumNu', 'In Magazijn', 'Niet Betaald', '$klantID', '$AdresID', '$totaalRond')";
        $db->exec($query);

//      pakt het laatste oder id ----------------------------------------------------------->
        $last_orderID = $db->lastInsertId();



    //      loopt door de winkelwagen heen ----------------------------------------------------------->
            foreach ($_SESSION["cart"] as $key => $product) {

    //      Kent waardes toe uit de winkel wagen ----------------------------------------------------------->
            $prodID = $product["productID"];
            $prodPrice = $product["productPrice"];
            $prodQuantity = $product["productQuantity"];

//          berekent de korting van de producten ----------------------------------------------------------->
            $artKorting = $prodPrice / 100 * $korting;
            $uiteindelijkeKorting = $prodPrice - $artKorting;
            $artRond = number_format($prodPrice, 2, '.', ',');

        //      Als de verkoopwijze huur is dan ----------------------------------------------------------->
                if ($product["productVerkoopwijze"] == 'Huur') {
                $prodVan = $product["datumVan"];
                $prodTot = $product["datumTot"];

            //      zet gegevens in de database ----------------------------------------------------------->
                    $query = "INSERT INTO orderregel (Order_ID, Artikel_ID, Aantal, Price, BeginDatum, EindDatum)  
                              VALUES ('$last_orderID', '$prodID', '$prodQuantity', '$artRond', '$prodVan', '$prodTot')";
                $db->exec($query);

            } else {
                //      zet gegevens in de database ----------------------------------------------------------->
                $query = "INSERT INTO orderregel (Order_ID, Artikel_ID, Aantal, Price, BeginDatum, EindDatum)  
                          VALUES ('$last_orderID', '$prodID', '$prodQuantity', '$artRond', '', '')";
                $db->exec($query);
            }
        }
        $kommaTotaalPrijs = str_replace('.', ',', $totaalRond);
        $text = 'Je bestelling is geplaatst \n Als je bestelling geleverd word moet je: € ' . $kommaTotaalPrijs . ' betalen. \n Je korting bedraagt ' . $korting. '% op het totaal bedrag.';
        session_destroy();
        echo
        "
        <script>
        alert('$text');
        location.href='index.php?page=cartForm';
        </script>
        "
        ;
    }




//      deze functie plaatsts de bestelling met korting ----------------------------------------------------------->
        public function bestellingZonderKorting($bezorgMethode, $klantID, $AdresID, $totaalBedrag) {

    //      hier probeerd hij te connecten met de database
            try {
                $db = new PDO("mysql:host=localhost;dbname=feestfabriek",DB_USER,DB_PASS);
                $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "test";
            }

            $punt = str_replace(',', '.', $totaalBedrag);
            if ($bezorgMethode === 'Bezorgen') {
                $plusBezorgKosten = $punt + 50.00;
            } else {
                $plusBezorgKosten = $punt;
            }
            $totaalRond = number_format($plusBezorgKosten, 2, '.', ',');

            $datumNu = date("Y-m-d");
            $query = "INSERT INTO orders (Bezorgopties, Orderdatum, BezorgStatus, BetaalStatus, Klant_ID, Adres_ID, totaalPrijs)  
            VALUES ('$bezorgMethode', '$datumNu', 'In Magazijn', 'Niet Betaald', '$klantID', '$AdresID', '$totaalRond')";
            $db->exec($query);

//          pakt het laatste oder id ----------------------------------------------------------->
            $last_orderID = $db->lastInsertId();

    //      loopt door de winkelwagen heen ----------------------------------------------------------->
            foreach ($_SESSION["cart"] as $key => $product) {

        //      Kent waardes toe uit de winkel wagen ----------------------------------------------------------->
                $prodID = $product["productID"];
                $prodPrice = $product["productPrice"];
                $prodQuantity = $product["productQuantity"];

//              berekent de korting van de producten ----------------------------------------------------------->
                $rond = number_format($prodPrice, 2, '.', ',');

                //      Als de verkoopwijze huur is dan ----------------------------------------------------------->
                if ($product["productVerkoopwijze"] == 'Huur') {
                    $prodVan = $product["datumVan"];
                    $prodTot = $product["datumTot"];

                    //      zet gegevens in de database ----------------------------------------------------------->
                    $query = "INSERT INTO orderregel (Order_ID, Artikel_ID, Aantal, Price, BeginDatum, EindDatum)  
                              VALUES ('$last_orderID', '$prodID', '$prodQuantity', '$rond', '$prodVan', '$prodTot')";
                    $db->exec($query);

                } else {
                    //      zet gegevens in de database ----------------------------------------------------------->
                    $query = "INSERT INTO orderregel (Order_ID, Artikel_ID, Aantal, Price, BeginDatum, EindDatum)  
                          VALUES ('$last_orderID', '$prodID', '$prodQuantity', '$rond', '', '')";
                    $db->exec($query);
                }
            }

        $kommaTotaalPrijs = str_replace('.', ',', $totaalRond);
        $text = 'Je bestelling is geplaatst \n Als je bestelling geleverd word moet je: € ' . $kommaTotaalPrijs. ' betalen.';
        session_destroy();
        echo
        "
        <script>
        alert('$text');
        location.href='index.php?page=cartForm';
        </script>
        "
        ;
    }


    public function maakNieuweGebruiker($AdresID, $naam, $achternaam, $tussenvoegsel, $email, $aanhef, $telefoonnummer, $bezorgMethode, $totaalBedrag) {
        try {
            $db = new PDO("mysql:host=localhost;dbname=feestfabriek",DB_USER,DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "test";
        }

//      als tussenvoegsel leeg is dan----------------------------------------------------------->
        if (empty($tussenvoegsel)) {

//          insert klant gegevens naar klant tabel zonder tussenvoegsel----------------------------------------------------------->
            $query = "INSERT INTO klant (Naam, Tussenvoegsel, Achternaam, Email, Telefoonnummer, Aanhef,  Korting, Adres_ID)  
                VALUES ('$naam', '', '$achternaam', '$email', '$telefoonnummer', '$aanhef', '0', '$AdresID')";
            $db->exec($query);

//          krijgt het laatste klant id----------------------------------------------------------->
            $last_klantID = $db->lastInsertId();
        } else {

//          insert klant gegevens naar klant tabel zonder tussenvoegsel----------------------------------------------------------->
            $query = "INSERT INTO klant (Naam, Tussenvoegsel, Achternaam, Email, Telefoonnummer, Aanhef,  Korting, Adres_ID)  
            VALUES ('$naam', '$tussenvoegsel', '$achternaam', '$email', '$telefoonnummer', '$aanhef', '0', '$AdresID')";
            $db->exec($query);
//          krijgt het laatste klant id
            $last_klantID = $db->lastInsertId();
        }

        $punt = str_replace(',', '.', $totaalBedrag);
        if ($bezorgMethode === 'Bezorgen') {
            $plusBezorgKosten = $punt + 50.00;
        } else {
            $plusBezorgKosten = $punt;
        }
        $totaalRond = number_format($plusBezorgKosten, 2, '.', ',');

//      insert order gegevens naar orders in de DB----------------------------------------------------------->
        $datumNu = date("Y-m-d");
        $query = "INSERT INTO orders (Bezorgopties, Orderdatum, BezorgStatus, BetaalStatus, Klant_ID, Adres_ID, totaalPrijs)  
                    VALUES ('$bezorgMethode', '$datumNu', 'In Magazijn', 'Niet Betaald', '$last_klantID', '$AdresID', '$totaalRond')";
        $db->exec($query);

//      krijgt laatste order id----------------------------------------------------------->
        $last_orderID = $db->lastInsertId();

//      loopt alle gegevens in het array en zet ze in de orderregels----------------------------------------------------------->
        foreach ($_SESSION["cart"] as $key => $product) {
            $prodID = $product["productID"];
            $prodNaam = $product["productName"];
            $prodPrice = $product["productPrice"];
            $prodQuantity = $product["productQuantity"];
            if ($product["productVerkoopwijze"] == 'Huur') {
                $prodVan = $product["datumVan"];
                $prodTot = $product["datumTot"];



//              zet gegevens met een datum in de database----------------------------------------------------------->
                $query = "INSERT INTO orderregel (Order_ID, Artikel_ID, Aantal, Price, BeginDatum, EindDatum)  
                    VALUES ('$last_orderID', '$prodID', '$prodQuantity', '$prodPrice', '$prodVan', '$prodTot')";
                $db->exec($query);
            } else {

//              zet gegevens met een datum in de database  ----------------------------------------------------------->
                $query = "INSERT INTO orderregel (Order_ID, Artikel_ID, Aantal, Price, BeginDatum, EindDatum)  
                    VALUES ('$last_orderID', '$prodID', '$prodQuantity', '$prodPrice', '', '')";
                $db->exec($query);
            }
        }

        $kommaTotaalPrijs = str_replace('.', ',', $totaalRond);
        $text = 'Je bestelling is geplaatst \n Als je bestelling geleverd word moet je: € ' . $kommaTotaalPrijs. ' betalen.';
        session_destroy();
        echo
        "
        <script>
        alert('$text');
        location.href='index.php?page=cartForm';
        </script>
        "
        ;
    }
}


