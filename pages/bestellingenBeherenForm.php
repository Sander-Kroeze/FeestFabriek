<?php
include('bestellingenBeheren.php');

if (isset($_POST["betaalStatusSet"])) {
    $status = htmlspecialchars($_POST["betaalStatus"]);
    $orderID = htmlspecialchars($_POST["orderId"]);

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
} elseif (isset($_POST["bezorgStatusSET"])) {
    $status = htmlspecialchars($_POST["bezorgStatus"]);
    $orderID = htmlspecialchars($_POST["orderId"]);

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
    }
    else{
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