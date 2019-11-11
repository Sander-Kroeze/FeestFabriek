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

//  haalt gegevens van DB op ----------------------------------------------------------->
$setSql = "SELECT * FROM ((orders INNER JOIN klant ON klant.ID = orders.Klant_ID) INNER JOIN adres ON adres.adresID = orders.Adres_ID) WHERE `orders_ID` = '$waarde'";
$stmt = $db->prepare($setSql);
$stmt->execute(array($waarde));
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);


header("Content-type: application/vnd.ms-word");

header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");


//  loopt door de orders en geeft waardes mee ----------------------------------------------------------->
    foreach ($orders as $order) {

        $naam =  $order["Naam"];
        $email = $order["Email"];
        $postcode = $order["Postcode"];
        $adres = $order["Adres"];
        $huisnr = $order["Huisnummer"];
        $id = $order["orders_ID"];
        $tel = $order["Telefoonnummer"];
        $bestDatum = $order["OrderDatum"];
        $korting = $order["Korting"];

    }
header("Content-Disposition: attachment; Filename=Factuur_nr_$id.doc");


    $date = new DateTime($bestDatum);
    $date->add(new DateInterval('P1D')); // P1D means a period of 1 day
    $Date2 = $date->format('d-m-Y');



    $origDate = $bestDatum;

    $newDate = date("d-m-Y", strtotime($origDate));

?>





<b><p style="text-align: center">Factuur</p></b>
<p>Factuur nummer: <?php echo $id ;?></p>


<!--table voor klant en bedrijf gegevens  ----------------------------------------------------------->
<table style="width:100%">
    <tr>
        <td width="50%"><?php echo $postcode ;?></td>
        <td align="right">1234AA</td>
    </tr>
    <tr>
        <td><?php echo $adres . " " . $huisnr ; ?></td>
        <td align="right">Laan van de laan 13</td>
    </tr>
    <tr>
        <td><?php echo $email ; ?>  </td>
        <td align="right">info@fff.nl</td>
    </tr>
    <tr>
        <td><?php echo $tel ; ?>  </td>
        <td align="right">0312345678</td>
    </tr>
</table>

<!--table voor bezorg gegevens  ----------------------------------------------------------->
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th, td {
        padding: 5px;
        align-content: center;
    }
</style>

<table style="width:100%;">
    <tr>
        <td width="33%">Bestel adres: <?php echo $adres . " " . $huisnr ; ?></td>
        <td width="33%">Bestel datum: <?php  echo $newDate; ?></td>
        <td width="33%">Bezorg datum: <?php  echo $Date2; ?></td>
    </tr>
</table>

<!--table voor bestelde artikelen -->
<table style="width:100%;">
    <thead>
        <th>Product Naam</th>
        <th>Omschrijving</th>
        <th>Verkoopwijze</th>
        <th>Artikel nummer</th>
        <th>Aantal/dagen</th>
        <th>Bedrag</th>
        <th>Totaal</th>
    </thead>
    <tbody>
    <?php
    $totaalPrijsAlles = 0;
    $setSql = "SELECT * FROM (((orderregel 
                INNER JOIN orders ON orders.orders_ID = orderregel.Order_ID) 
               INNER JOIN artikel ON artikel.ID = orderregel.Artikel_ID)
               INNER JOIN verkoopwijze ON verkoopwijze.Verkoopwijze_ID = artikel.Verkoopwijze_ID)
               WHERE `Order_ID` = '$id'";
    $stmt = $db->prepare($setSql);
    $stmt->execute(array($waarde));
    $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($artikelen as $artikel) {

//      enkele prijs van een betaal product -------------------------------------------->
        $ordRegelPrijs = $artikel["Price"];
        $euro = $ordRegelPrijs / 60;
        $totaalRond = number_format($euro, 2, '.', ',');
        $artikelPrijsKomma = str_replace('.', ',', $totaalRond);
//      totaal prijs per product ----------------------------------------------->
        $prijs = $artikel["Price"] / 60;
        $afgerond = number_format($prijs, 2, '.', ',');
        $komma2 = str_replace('.', ',', $afgerond);
        $prijs2 = $afgerond * $artikel["Aantal"];
        $afgerond2 = number_format($prijs2, 2, '.', ',');
        $komma = str_replace('.', ',', $afgerond2);
//      totaal prijs van alles -------------------------------------->
        $totaalPrijs = $artikel["totaalPrijs"];
        $kommaPrijs = str_replace('.', ',', $totaalPrijs);

        if ($artikel["Verkoopwijze_Naam"] === 'Huur') {
            $datetime1 = new DateTime($artikel["BeginDatum"]);
            $datetime2 = new DateTime($artikel["EindDatum"]);
            $interval = $datetime1->diff($datetime2);
            $dagen = $interval->format('%a');
            $prijs = $artikel["Price"] / 60;


            $day   = 24 * 3600;
            $from  = strtotime($artikel["BeginDatum"]);
            $to    = strtotime($artikel["EindDatum"]) + $day;
            $diff  = abs($to - $from);
            $weeks = floor($diff / $day / 7);
            $days  = $diff / $day - $weeks * 7;
            $dagen = $days - 1;
            $out   = array();

            if ($weeks) {
                $out[] = "$weeks Week" . ($weeks > 1 ? 'en' : '');

                $afgerond = number_format($prijs, 2, '.', ',');
                $weekPrijs = $afgerond * 6;
                $totaalWeekPrijs = $weekPrijs * $weeks;
            }

            if ($dagen) {
                $out[] = "$dagen dag" . ($dagen > 1 ? 'en' : '');
                $totaalDagPrijs = $prijs * $dagen;
            }

            if (!empty($weeks) && !empty($dagen)) {
                $totaal = $totaalDagPrijs + $totaalWeekPrijs;
                $afgerondWD = number_format($totaal, 2, '.', ',');
                $komma = str_replace('.', ',', $afgerondWD);
            } elseif (!empty($weeks) && empty($dagen)) {
                $totaal = $totaalWeekPrijs;
                $komma = str_replace('.', ',', $totaal);
            } elseif (empty($weeks) &&!empty($dagen)) {
                $totaal = $totaalDagPrijs;
                $afgerondWD = number_format($totaal, 2, '.', ',');
                $komma = str_replace('.', ',', $afgerondWD);
            }
            $totaalPrijsAlles += $afgerondWD;
        } else {
            $prijs = $artikel["Price"] / 60;
            $afgerond = number_format($prijs, 2, '.', ',');
            $komma2 = str_replace('.', ',', $afgerond);
            $prijs2 = $afgerond * $artikel["Aantal"];
            $afgerond2 = number_format($prijs2, 2, '.', ',');
            $komma = str_replace('.', ',', $afgerond2);

            $totaalPrijsAlles += $prijs2;
        }

        ?>
        <tr>
            <td><?php echo $artikel["Naam"] ;?></td>
            <td><?php echo substr($artikel["Omschrijving"],0, 10); ?> ...</td>
            <td><?php echo $artikel["Verkoopwijze_Naam"] ;?></td>
            <td><?php echo $artikel["ID"] ;?></td>
            <td><?php if ($artikel["Verkoopwijze_Naam"] === 'Huur'){echo implode(' en ', $out);} else { echo $artikel["Aantal"];}?></td>
            <td><?php echo $artikelPrijsKomma ;?></td>
            <td><?php echo $komma;?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<br>
<style>
    table, th, td {
        border: 1px solid White;
        border-collapse: collapse;
    }

    th, td {
        padding: 5px;
        align-content: center;
    }
</style>
<table style="width:100%;">
    <?php $BedragZonderKorting = str_replace('.', ',', $totaalPrijsAlles); ?>
    <tr>
        <td width="33%"></td>
        <td width="33%"></td>
        <td width="33%"><u>Subtotaal: <?php echo  $BedragZonderKorting ;?></u></td>
    </tr>
    <tr>
        <td width="33%"></td>
        <td width="33%"></td>
        <td width="33%"><u>Korting: <?php echo  $korting ;?> %</u></td>
    </tr>
    <?php
    $artKorting = $totaalPrijsAlles / 100 * $korting;
    $uiteindelijkeKorting = $totaalPrijsAlles - $artKorting;
    $artRond = number_format($uiteindelijkeKorting, 2, '.', ',');
    $totaalMetKorting = str_replace('.', ',', $artRond);
    ?>
    <tr>
        <td width="33%"></td>
        <td width="33%"></td>
        <td width="33%"><u>Totaal bedrag: <?php echo  $totaalMetKorting ;?></u></td>
    </tr>
</table>



