<?php
include("artikelDetailPagina.php");

if (isset($_POST["submit_huur"])) {

//  haalt de gegevens op van de form ----------------------------------------------------------->
    $datumVan = htmlspecialchars($_POST["datumVan"]);
    $datumTot = htmlspecialchars($_POST["datumTot"]);
    $prodID = htmlspecialchars($_POST["prod_id"]);
    $prodName = htmlspecialchars($_POST["prod_name"]);
    $prodImage = htmlspecialchars($_POST["prod_image"]);
    $prodPrice = htmlspecialchars($_POST["prod_price"]);
    $prodCategory = htmlspecialchars($_POST["prod_category"]);
    $prodVerkoopwijze = htmlspecialchars($_POST["prod_verkoopwijze"]);
    $prodQuantity = 1;

    $datetime1 = new DateTime($datumVan);
    $datetime2 = new DateTime($datumTot);
    $interval = $datetime1->diff($datetime2);
//    echo $interval->format('%R%a days');

    $dagen = $interval->format('%a');

    $nu = date("Y-m-d");
    $now = time(); // or your date as well
    $myDate = strtotime("2019-10-30");
    $your_date = strtotime("2019-11-20");
    $datediff = $your_date - $myDate;
//                  echo round($datediff / (60 * 60 * 24));
    $morgenBestelDatum =  date('Y-m-d', strtotime(' + 1 days'));
    $minBestelDatum =  date('Y-m-d', strtotime(' + 2 days'));


    $now = date("Y-m-d");
    $date1 = date_create("$morgenBestelDatum");
    $date2 = date_create("$datumVan");
    $diff = date_diff($date1, $date2);
    $verschil = $diff->format("%R%a");

    if ($verschil  <= '-1') {
        echo "<script> alert('Uw datum klopt niet, u kunt geen oude datums en vandaag selecteren' +
            ' U wordt terug gestuurd'); location.href='index.php?page=artikelDetailForm&artikel=$prodID';</script>";
        exit;
    }

//  controleerd of datumVan kleiner of gelijk is aan datumTot ----------------------------------------------------------->
    if ($datumVan <= $datumTot) {
        $newItem = array(
            'productID' => $prodID,
            'productName' => $prodName,
            'productPrice' => $prodPrice,
            'productImage' => $prodImage,
            'productCategory' => $prodCategory,
            'productVerkoopwijze' => $prodVerkoopwijze,
            'datumVan' => $datumVan,
            'datumTot' => $datumTot,
            'productQuantity' => $dagen
        );

//      als de waarde sessionCart leeg is dan ----------------------------------------------------------->
        if(!empty($_SESSION['cart'])) {

            // als het artikel van het verhuurMethode: huren al bestaat in het array
            if(isset($_SESSION['cart'][$prodID]) == $prodID) {
                echo "<script> alert('U kunt niet twee keer het zelfde product huren...' +
            'U wordt terug gestuurd'); location.href='index.php?page=producten';</script>";
            } else {

                // als dit niet het geval is, voeg het product toe
                $_SESSION['cart'][$prodID] = $newItem;
            }
        } else  {

//          als de session wel leeg is dan  ----------------------------------------------------------->
            $_SESSION['cart'] = array();
            $_SESSION['cart'][$prodID] = $newItem;
        }

//      redirect je door naar de winkelwagen ----------------------------------------------------------->
        echo '
        <script>
        alert("Het product zit in je bestellingen! \n U wordt door gestuurd naar je winkelwagen.");
        location.href=\'index.php?page=cartForm\';
        </script>
        '
        ;

    } else {

    //  redirect je naar de admin pagina ----------------------------------------------------------->
        echo '
        <script>
        alert("De tot datum moet minimaal 1 dag over de van datum zijn. \n U wordt terug gestuurd.");
        location.href=\'index.php?page=cartForm\';
        </script>
        '
        ;
        exit;
    }

} else if (isset($_POST["submit_betaal"])) {

//  haalt gegevens op van de form ----------------------------------------------------------->
    $prodID = htmlspecialchars($_POST["prod_id"]);
    $prodName = htmlspecialchars($_POST["prod_name"]);
    $prodImage = htmlspecialchars($_POST["prod_image"]);
    $prodPrice = htmlspecialchars($_POST["prod_price"]);
    $prodCategory = htmlspecialchars($_POST["prod_category"]);
    $prodVerkoopwijze = htmlspecialchars($_POST["prod_verkoopwijze"]);
    $prodQuantity = htmlspecialchars($_POST["Aantal"]);

//  controleerd of de quantity die is ingevoerd hoger is dan 1 ----------------------------------------------------------->
    if ($prodQuantity >= 1) {

    //  maakt een array met de gegevens van de form ----------------------------------------------------------->
        $newItem = array(
            'productID' => $prodID,
            'productName' => $prodName,
            'productPrice' => $prodPrice,
            'productImage' => $prodImage,
            'productQuantity' => $prodQuantity,
            'productCategory' => $prodCategory,
            'productVerkoopwijze' => $prodVerkoopwijze
        );

    //  controleerd of de variable niet leeg is ----------------------------------------------------------->
        if (!empty($_SESSION['cart'])) {

            //  als er al een product is met het zelfde id ----------------------------------------------------------->
            if (isset($_SESSION['cart'][$prodID]) == $prodID) {
                $_SESSION["cart"][$prodID]["productQuantity"] += $prodQuantity;

            //  redirect je naar de admin pagina ----------------------------------------------------------->
                echo '
                <script>
                alert("Uw prodcut aantal is verhoogd\' \n U wordt door gestuurd naar de winkelwagen");
                location.href=\'index.php?page=cartForm\';
                </script>
                '
                ;
            } else {

            //  als het niet het zelfde is voeg het array toe ----------------------------------------------------------->
                $_SESSION['cart'][$prodID] = $newItem;
            }
        } else {

        //  als hij leeg is voeg een array toe en het nieuwe array ----------------------------------------------------------->
            $_SESSION['cart'] = array();
            $_SESSION['cart'][$prodID] = $newItem;
        }

    //  redirect je naar je winkelwagen pagina ----------------------------------------------------------->
        echo '
        <script>
        alert("Het product zit in je bestellingen! \n U wordt door gestuurd naar je winkelwagen.");
        location.href=\'index.php?page=cartForm\';
        </script>
        '
        ;
    } else {

    //  geeft je een melding ----------------------------------------------------------->
        echo '
        <script>
        alert("Het product aantal moet hoger zijn dan 0! \n U wordt terug gestuurd.");
        </script>
        '
        ;
        exit;
    }
}
