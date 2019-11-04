<div class="product-detail-center">

<?php
    $query = "SELECT * FROM ((artikel INNER JOIN categorie ON artikel.Categorie_ID = categorie.Categorie_ID) INNER JOIN verkoopwijze ON artikel.Verkoopwijze_ID = verkoopwijze.Verkoopwijze_ID) WHERE ID = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($_GET['artikel']));
$artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($artikelen as $artikel) {
    if ($artikel["Onderhoud"] == 1) {
        $s = $artikel["Image"];
        ?>
        <div class="product-detail-border">
            <div class="product-column1">
                <h2><?php echo $artikel["Naam"]; ?></h2>
                <button class="prod-button" onclick="location.href='index.php?page=producten'">Ga Terug</button>
                <br><img class="product-img" src="img/<?php echo $s;?>" alt=""><br>
                <div class="product-form">
                    <?php

                    $nu = date("Y-m-d");
                    $now = time(); // or your date as well
                    $myDate = strtotime("2019-10-30");
                    $your_date = strtotime("2019-11-20");
                    $datediff = $your_date - $myDate;
//                  echo round($datediff / (60 * 60 * 24));
                    $minBestelDatum =  date('Y-m-d', strtotime(' + 1 days'));

                    if ($artikel["Verkoopwijze_Naam"] == "Huur") {
                        ?>
                        <form method="POST" enctype="multipart/form-data" action="">
                            <div class="form-left">
                                <p>Huren van</p>
                                <input type="date" name="datumVan" min="<?php echo $nu; ?>" required>
                                <p>Huren tot</p>
                                <input type="date" name="datumTot" min="<?php echo $minBestelDatum; ?>" required>
                            </div>
                            <div class="form-right">
                                <input type="hidden" name="prod_id" value="<?php echo $artikel["ID"]; ?>" />
                                <input type="hidden" name="prod_name" value="<?php echo $artikel["Naam"]; ?>" />
                                <input type="hidden" name="prod_image" value="<?php echo $artikel["Image"]; ?>" />
                                <input type="hidden" name="prod_price" value="<?php echo $artikel["Prijs"]; ?>" />
                                <input type="hidden" name="prod_category" value="<?php echo $artikel["Categorie_naam"];?>">
                                <input type="hidden" name="prod_verkoopwijze" value="<?php echo $artikel["Verkoopwijze_Naam"];?>">
                                <input type="hidden"  name="submit_huur" value="true" />
                                <input  class="prod-button" type="submit" id="submit" value=" Voeg toe " /><br>
                                <div style="padding-top: 60px;">
                                    <a  class="prod-button" onclick="location.href='index.php?page=cartForm'">Bekijk je winkelwagen</a>
                                </div>
                            </div>
                        </form>
                        <?php
                    } else {
                        ?>
                        <form method="POST" enctype="multipart/form-data" action="">
                            <div class="form-left">
                                <p>Aantal</p>
                                <input type="number" name="Aantal" required min="0">
                            </div>
                            <div class="form-right">
                                <input type="hidden" name="prod_id" value="<?php echo $artikel["ID"]; ?>" />
                                <input type="hidden" name="prod_name" value="<?php echo $artikel["Naam"]; ?>" />
                                <input type="hidden" name="prod_image" value="<?php echo $artikel["Image"]; ?>" />
                                <input type="hidden" name="prod_price" value="<?php echo $artikel["Prijs"]; ?>" />
                                <input type="hidden" name="prod_category" value="<?php echo $artikel["Categorie_naam"];?>">
                                <input type="hidden" name="prod_verkoopwijze" value="<?php echo $artikel["Verkoopwijze_Naam"];?>">
                                <input type="hidden"  name="submit_betaal" value="true" />
                                <input  class="prod-button" type="submit" id="submit" value=" Voeg toe " /><br>
                                <div style="padding-top: 60px;">
                                    <a  class="prod-button" onclick="location.href='index.php?page=cartForm'">Bekijk je winkelwagen</a>
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="product-column2 ">
                <h2>Omschrijving</h2>
                <p><?php echo $artikel["Omschrijving"];?></p>
                <h2>Categorie</h2>
                <p><?php echo $artikel["Categorie_naam"] . ", " . $artikel["Verkoopwijze_Naam"];?></p>
                <h2>Prijs</h2>
                <?php
                    if ($artikel["Verkoopwijze_Naam"] == "Betaal") {
                        $prijs = $artikel["Prijs"] / 60;
                        $afgerond = number_format($prijs, 2, '.', ',');
                        $komma = str_replace('.', ',', $afgerond);
                        echo "Prijs € " . $komma;
                    } else {
                        $prijs = $artikel["Prijs"] / 60;
                        $afgerond = number_format($prijs, 2, '.', ',');
                        $komma = str_replace('.', ',', $afgerond);
                        echo "Prijs per dag € " . $komma;
                    }
                ?>
            </div>
        </div>
        <?php
    } else {
        echo "
      <script>
        alert('Dit artikel is in onderhoud!' +
         ' U wordt nu terug gestuurd.');
        location.href='index.php?page=producten';
      </script>
      ";
    }
}
?>
</div>