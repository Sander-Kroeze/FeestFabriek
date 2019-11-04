<?php

include('productenBeheren.php');

if (isset($_POST["inOnderhoud"])) {

//  haalt gegevens op van de form ----------------------------------------------------------->
    $productID = htmlspecialchars($_POST["productID"]);
    $onderhoudStatus = htmlspecialchars($_POST["onderhoudWaarde"]);

//  Zet de gegevens in de database ----------------------------------------------------------->
    $query_updateArtikel = "UPDATE artikel SET Onderhoud = '$onderhoudStatus' WHERE ID = '$productID'";
    $db->exec($query_updateArtikel);

//  redirect je terug met een alert ----------------------------------------------------------->
    echo "
            <script>
            alert('Het product is bijgewerkt id: $productID');
            location.href='index.php?page=productenBeherenForm';
              </script>
         "
    ;
}
