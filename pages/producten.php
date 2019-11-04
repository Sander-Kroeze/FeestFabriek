<h1>Producten</h1>
<div class="cart-center">
    <form style="width: 20%" action="" method="POST" enctype="multipart/form-data">
        <select class="test" name="filterwaarde" onchange='this.form.submit()'>
            <option>Kies een filter</option>
            <option value="niks">Alles</option>
            <?php
            //    $query = "SELECT * FROM artikel";
            $query = "SELECT * FROM categorie";
            $stmt = $db->prepare($query);
            $stmt->execute(array());
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($categories as $cat) {
                ?>
                <option value="<?php echo $cat["Categorie_naam"];?>"><?php echo $cat["Categorie_naam"]; ?></option>
            <?php
            }
            ?>
        </select>
        <noscript><input type="submit" value="submit"></noscript>
        <input type="hidden" name="filter" value="true">
    </form>
</div>

<div class="flex-container">
    <?php

    if(isset($_POST["filter"])) {
        $filter = htmlspecialchars($_POST["filterwaarde"]);
        // haalt de $artikel uit de database
        if ($filter === 'niks') {
            $query = "SELECT * FROM ((artikel INNER JOIN categorie ON artikel.Categorie_ID = categorie.Categorie_ID) INNER JOIN verkoopwijze ON artikel.Verkoopwijze_ID = verkoopwijze.Verkoopwijze_ID)";
        } else {
            $query = "SELECT * FROM ((artikel INNER JOIN categorie ON artikel.Categorie_ID = categorie.Categorie_ID) INNER JOIN verkoopwijze ON artikel.Verkoopwijze_ID = verkoopwijze.Verkoopwijze_ID) WHERE Categorie_naam = '$filter'";
        }
    } else {
        $query = "SELECT * FROM ((artikel INNER JOIN categorie ON artikel.Categorie_ID = categorie.Categorie_ID) INNER JOIN verkoopwijze ON artikel.Verkoopwijze_ID = verkoopwijze.Verkoopwijze_ID)";

    }


    //    $query = "SELECT * FROM artikel";
    $stmt = $db->prepare($query);
    $stmt->execute(array());
    $artikelen = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $bgcolor = true;
    foreach ($artikelen as $artikel) {
        $img = $artikel["Image"];
        ?>
        <div>
            <div class="product-tumb">
                <img src="img/<?php echo $img;?>" alt="">
            </div>
            <div class="product-details">
                <span class="product-catagory"><?php echo $artikel["Categorie_naam"] . ", " . $artikel["Verkoopwijze_Naam"];?></span><br>
                <a href='index.php?page=artikelDetailForm&artikel=<?php echo $artikel["ID"]; ?>'><?php echo $artikel["Naam"];?></a><br>
                <p>
                    <?php echo $artikel["Omschrijving"]; ?>
                </p><br>
                <?php
                $prijs = $artikel["Prijs"] / 60;
                $afgerond = number_format($prijs, 2, '.', ',');
                $komma = str_replace('.', ',', $afgerond);
                ?>
                <p>Prijs: € <?php echo $komma; ?></p>
            </div>
        </div>
        <?php
    }
    ?>
</div>













