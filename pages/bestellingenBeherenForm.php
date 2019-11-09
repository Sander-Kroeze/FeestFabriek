<?php
include('bestellingenBeheren.php');

//  als de betaal status is geset ----------------------------------------------------------->
if (isset($_POST["betaalStatusSet"])) {

//  geef waardes mee ----------------------------------------------------------->
    $status = htmlspecialchars($_POST["betaalStatus"]);
    $orderID = htmlspecialchars($_POST["orderId"]);

//  als status gelijk is aan ----------------------------------------------------------->
    if ($status === 'Niet Betaald' || $status === 'Betaald'){
        //  Zet de gegevens in de database ----------------------------------------------------------->
        $query_updateArtikel = "UPDATE orders SET BetaalStatus = '$status' WHERE orders_ID = '$orderID'";
        $db->exec($query_updateArtikel);

    //  redirect je terug met een alert ----------------------------------------------------------->
        echo "
            <script>
            alert('De order die is bijgewerkt: $orderID');
            location.href='index.php?page=bestellingenBeherenForm';
              </script>
         "
        ;
//  redirect je terug met een alert ----------------------------------------------------------->
    } else{
        echo
        "
        <script>
        alert('de ingeoverde gegevens zijn ongeldig');
        </script>
        "
        ;
        exit;
    }
//  als de bezorg status is geset ----------------------------------------------------------->
} elseif (isset($_POST["bezorgStatusSET"])) {
//  geeft waardes mee ----------------------------------------------------------->
    $status = htmlspecialchars($_POST["bezorgStatus"]);
    $orderID = htmlspecialchars($_POST["orderId"]);

//  als status gelijk is aan dan ----------------------------------------------------------->
    if ($status === 'In Magazijn' || $status === 'Onderweg' || $status === 'Bezorgd'){
        //  Zet de gegevens in de database ----------------------------------------------------------->
        $query_updateArtikel = "UPDATE orders SET BezorgStatus = '$status' WHERE orders_ID = '$orderID'";
        $db->exec($query_updateArtikel);

        //  redirect je terug met een alert ----------------------------------------------------------->
        echo "
            <script>
            alert('De order die is bijgewerkt: $orderID');
            location.href='index.php?page=bestellingenBeherenForm';
              </script>
         "
        ;
//  als status geijk is aan ----------------------------------------------------------->
    } elseif ($status === 'Retour') {
        $query_updateArtikel = "UPDATE orders SET Retour = '$status' WHERE orders_ID = '$orderID'";
        $db->exec($query_updateArtikel);

    //  redirect je terug met een alert ----------------------------------------------------------->
        echo "
            <script>
            alert('De order die is bijgewerkt: $orderID');
            location.href='index.php?page=bestellingenBeherenForm';
              </script>
         "
        ;
//   ----------------------------------------------------------->
    } elseif ($status === "Retour Bezorgd") {
        $query_updateArtikel = "UPDATE orders SET Retour = '$status' WHERE orders_ID = '$orderID'";
        $db->exec($query_updateArtikel);

    //  redirect je terug met een alert ----------------------------------------------------------->
        echo "
            <script>
            alert('De order die is bijgewerkt: $orderID');
            location.href='index.php?page=bestellingenBeherenForm';
              </script>
         "
        ;
    }
    else {

        //  redirect je terug met een alert ----------------------------------------------------------->
        echo
        "
        <script>
        alert('de ingevoerde gegevens zijn ongeldig');
        </script>
        "
        ;
        exit;
    }
}