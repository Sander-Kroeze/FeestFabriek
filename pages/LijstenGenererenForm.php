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
    $setSql = "SELECT * FROM ((orders INNER JOIN klant ON klant.ID = orders.Klant_ID) INNER JOIN adres ON adres.adresID = orders.Adres_ID) WHERE `BezorgOpties` = 'Bezorgen' OR BezorgOpties = 'Retour' ORDER BY adres.Postcode";
    $stmt = $db->prepare($setSql);
    $stmt->execute(array('Bezorgen'));

    $connection = mysqli_connect("localhost", "root", "",
        "feestfabriek");
    $result = mysqli_query($connection, $setSql);
    header("Content-Disposition: attachment; filename=Lijst_Bezorgen_Ophalen.xls");
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
        $setSql = "SELECT * FROM ((orders INNER JOIN klant ON klant.ID = orders.Klant_ID) INNER JOIN adres ON adres.adresID = orders.Adres_ID) WHERE `BezorgOpties` = 'Ophalen' OR BezorgOpties = 'Retour' ORDER BY adres.Postcode";
        $stmt = $db->prepare($setSql);
        $stmt->execute(array('Ophalen'));
    $connection = mysqli_connect("localhost", "root", "",
        "feestfabriek");
    $result = mysqli_query($connection, $setSql);
    header("Content-Disposition: attachment; filename=Lijst_afhalen_terugbrengen.xls");
    }
//    $setRec = mysqli_query($conn, $setSql);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $columnHeader = "Naam" . "\t" . "Achternaam" . "\t" . "Factuurnummer" . "\t" . "Adres en huisnummer" . "\t" . "Postcode" . "\t" . "Totaalprijs" . "\t" . "Status";

    $setData = '';
    $orderLength = sizeof($orders);
$row = mysqli_num_rows($result);



for ($x = 0; $x <=$row; $x++) {
       $rowData = '';
       foreach ($orders as $value) {
           $now = date("Y-m-d");
           $test = $value["OrderDatum"];
           $date1=date_create("$now");
           $date2=date_create("$test");
           $diff=date_diff($date1,$date2);
           $verschil =  $diff->format("%R%a");
           if( $verschil === '+0') {

               $bedrag = $value["totaalPrijs"];
               $kommaTotaalPrijs = str_replace('.', ',', $bedrag);
               $test = $value["Naam"] . "\t" .
               $value["Tussenvoegsel"] . " " . $value["Achternaam"] . "\t" .
               $value["orders_ID"] . "\t" .
               $value["Adres"] . " " . $value["Huisnummer"] . "\t" .
               $value["Postcode"] . "\t" .
               $kommaTotaalPrijs . "\t".
               $value["BezorgOpties"] . "\t";

               $rowData .= $test . "\n";
               $x++;
           } elseif ($value["Retour"] === 'Retour') {
               $bedrag = $value["totaalPrijs"];
               $kommaTotaalPrijs = str_replace('.', ',', $bedrag);
               $test = $value["Naam"] . "\t" .
               $value["Tussenvoegsel"] . " " . $value["Achternaam"] . "\t" .
               $value["orders_ID"] . "\t" .
               $value["Adres"] . " " . $value["Huisnummer"] . "\t" .
               $value["Postcode"] . "\t" .
               $kommaTotaalPrijs . "\t".
               $value["Retour"] . "\t";
               $rowData .= $test . "\n";
               $x++;
           }
       }
       $setData .= trim($rowData) . "\n";
   }

    header("Content-type: application/vnd.ms-excel; name='exel'");

    header("Pragma: no-cache");
    header("Expires: 0");

    echo $columnHeader . "\n" . $setData;

?>