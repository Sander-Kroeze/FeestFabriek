<?php

$waarde = htmlspecialchars($_POST["orderId"]);

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

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");

$setSql = "SELECT * FROM ((orders INNER JOIN klant ON klant.ID = orders.Klant_ID) INNER JOIN adres ON adres.adresID = orders.Adres_ID) WHERE `orders_ID` = '$waarde'";
$stmt = $db->prepare($setSql);
$stmt->execute(array($waarde));
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo "<center><b>Factuur</b></center>";
foreach ($orders as $value) {
        $orderNr = $value["orders_ID"];
        $klant_adres = $value["Adres"] . " " . $value["Huisnummer"];
}

echo '<pre>Factuurnummr:'. $orderNr .'                                        Freds Feest Fabriek</pre>';
echo '<pre>Factuurnummr:'. $klant_adres .'                                  Laan van de laan 13</pre>';
echo '<pre>Factuurnummr:'. $orderNr .'                                        1234 AA</pre>';
echo '<pre>Factuurnummr:'. $orderNr .'                                        Hardenberg</pre>';
echo '<pre>Factuurnummr:'. $orderNr .'                                        info@fff.nl</pre>';
echo '<pre>Factuurnummr:'. $orderNr .'                                        0612345678</pre>';

echo "</body>";
echo "</html>";

?>

