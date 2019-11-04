<h1 style="color: white">Dikke Bestelling</h1>

<div class="cart-center">
    <div class="cart-border">
        <table>
            <tr>
                <th>Afbeelding</th>
                <th>Naam</th>
                <th>Aantal</th>
                <th>Prijs</th>
                <th>Verwijder</th>
            </tr>
        <?php
        if (empty($_SESSION["cart"])) {
            echo "je heb geen producten in je Winkelwagen zitten";
        } else {
            $totaalCenten = 0;
            $totaalPrijs = 0;
            foreach($_SESSION["cart"] as $key => $product) {
                $s = $product["productImage"];
                echo "<tr>";
                    echo "<td><img class='product-img' src='img/$s' style='width: 100px'></td>"; ?>
                    <td><a style="cursor: pointer" onclick="location.href='index.php?page=artikelDetailForm&artikel=<?php echo $product["productID"]; ?>'" "></a><?php echo $product["productName"]; ?></td>
                <?php
                    echo "<td>" . $product["productQuantity"] . "</td>";

                if ($product["productVerkoopwijze"] == 'Huur') {
                    $datetime1 = new DateTime($product["datumVan"]);
                    $datetime2 = new DateTime($product["datumTot"]);
                    $interval = $datetime1->diff($datetime2);
                    $dagen = $interval->format('%a');
                    $prijs = $product["productPrice"] / 60;
                    $afgerond = number_format($prijs, 2, '.', ',');
                    $prod_prijs = $afgerond * $dagen;
                    $komma = str_replace('.', ',', $prod_prijs);
                    echo "<td>" . $komma . "</td>";
                    $totaalPrijs += $prod_prijs;
                    $voorTotaalCenten = $product["productPrice"] * $dagen;
                    $totaalCenten += $voorTotaalCenten;
                } else {
                    $prijs = $product["productPrice"] / 60;
                    $afgerond = number_format($prijs, 2, '.', ',');
                    $komma2 = str_replace('.', ',', $afgerond);
                    $prijs2 = $afgerond * $product["productQuantity"];
                    $afgerond2 = number_format($prijs2, 2, '.', ',');
                    $komma = str_replace('.', ',', $afgerond2);

                    echo "<td>" . $komma . "</td>";
                    $totaalPrijs += $prijs2;
                    $geld = $product["productPrice"] * $product["productQuantity"];
                    $totaalCenten += $geld;
                }
                    echo "<td>";
                    ?>
                    <form method="POST" enctype="multipart/form-data" action="">
                        <input type="hidden"  name="productID" value="<?php echo $product["productID"]; ?>" />
                        <input type="hidden"  name="submit_verwijder" value="true" />
                        <input  class="prod-button" type="submit" id="submit" value=" Verwijder " />
                    </form>
                     <?php
                    echo "</td>";
                echo "</tr>";
            }
            $rond = number_format($totaalPrijs, 2, '.', ',');
            $totaalKomma = str_replace('.', ',', $rond);
            echo "<tr>";
            echo "<td></td></td><td></td><td> Totaal Prijs = </td>";
            echo "<td>€ $totaalKomma</td><td></td>";
        }
        ?>
        </table>
        <br><br>
        <form class="order-form" method="POST" enctype="multipart/form-data" action="">
            <input type="text" name="Naam" placeholder=" Voornaam*" value="" required>
            <input type="text" name="Tussenvoegsel" placeholder=" Tussenvoegsel" value="">
            <input type="text" name="Achternaam" placeholder=" Achternaam*" value="" required>
            <input type="radio" name="Aanhef" value="De heer" checked> De heer
            <input type="radio" name="Aanhef" value="Mevrouw" checked> Mevrouw
            <br><br>
            <input class="test" type="text" name="Straatnaam" placeholder="Straatnaam*" size="45" required>
            <input type="text" name="Huisnummer" placeholder="Huisnummer*" required>
            <input type="email" name="Email" placeholder="Email*" size="48" required>
            <br><br><br>
            <input type="text" name="Postcode" placeholder="Postcode*" required>
            <input type="radio" name="BezorgMethode" value="Bezorgen" checked> Bezorgen
            <input type="radio" name="BezorgMethode" value="Ophalen" checked> Ophalen
            <input type="text" name="Telefoonnummer" placeholder="Telefoonnummer*" required>
            <input type="text" name="Land" placeholder="Land*" required>
            <input type="hidden" name="totaalBedrag" value="<?php echo $rond;?>" />
            <input type="hidden" name="totaalCenten" value="<?php echo $totaalCenten;?>">
            <input type="hidden"  name="submit_order" value="true" />
            <input class="prod-button" type="submit" name="submit" id="submit" value=" Plaats je Bestelling ">
            <br><br>
        </form>
        </div>
    </div>
</div>







