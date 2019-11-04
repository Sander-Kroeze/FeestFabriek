<?php
    $waarde = htmlspecialchars($_POST["waarde"]);
    $conn = new mysqli('localhost', 'root', '');
    mysqli_select_db($conn, 'feestfabriek');

    // user name voor database.
    DEFINE("DB_USER", "root");
    // wachtwoord voor database.
    DEFINE("DB_PASS", "");
    // hier probeerd hij te connecten met de database
    try {
        $db = new PDO("mysql:host=localhost;dbname=feestfabriek",DB_USER,DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }


if ($waarde == 1) {
    $setSql = "SELECT * FROM ((orders INNER JOIN klant ON klant.ID = orders.Klant_ID) INNER JOIN adres ON adres.adresID = orders.Adres_ID) WHERE `BezorgOpties` = 'Bezorgen'";
    $stmt = $db->prepare($setSql);
    $stmt->execute(array('Bezorgen'));
    header("Content-Disposition: attachment; filename=Lijst_Bezorgen.xls");
    } elseif ($waarde == 0) {
        $previous = "javascript:history.go(-1)";
        if(isset($_SERVER['HTTP_REFERER'])) {
            $previous = $_SERVER['HTTP_REFERER'];
        }
        echo
        "
        <script>
        alert('Selecteer een lijst');
        location.href='$previous';
        </script>
        "
        ;
        exit;
    }else {
        $setSql = "SELECT * FROM ((orders INNER JOIN klant ON klant.ID = orders.Klant_ID) INNER JOIN adres ON adres.adresID = orders.Adres_ID) WHERE `BezorgOpties` = 'Ophalen'";
        $stmt = $db->prepare($setSql);
        $stmt->execute(array('Ophalen'));
    header("Content-Disposition: attachment; filename=Lijst_ophalen.xls");
    }
//    $setRec = mysqli_query($conn, $setSql);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columnHeader = "Naam" . "\t" . "Achternaam" . "\t" . "Factuurnummer" . "\t" . "Totaalprijs";

    $setData = '';
    $orderLength = sizeof($orders);


   for ($x = 1; $x <= $orderLength; $x++) {
       $rowData = '';
       foreach ($orders as $value) {
           $bedrag = $value["totaalPrijs"];
           $kommaTotaalPrijs = str_replace('.', ',', $bedrag);
           $test = $value["Naam"] . "\t" .
           $value["Tussenvoegsel"] . " " . $value["Achternaam"] . "\t" .
           $value["orders_ID"] . "\t" .
           $kommaTotaalPrijs;
           $rowData .= $test;
       }
       $setData .= trim($rowData) . "\n";

       $x++;
   }

    header("Content-type: application/vnd.ms-excel; name='exel'");

    header("Pragma: no-cache");
    header("Expires: 0");

    echo $columnHeader . "\n" . $setData;

?>