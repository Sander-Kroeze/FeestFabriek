<?php
if (isset($_SESSION["ID"])) {
    ?>
    <h2>ADMIN</h2>

    <div class="cart-center">
        <div class="cart-border">
            <nav class="admin-navigation">
                <ul>
                    <li>
                        <a style="cursor:pointer;" class="nav_a" id="a" "><?php echo $_SESSION["USER"]; ?></a>
                    </li>
                    <li>
                        <a style="cursor:pointer;" class="nav_a <?php if ($_GET["page"] == 'formAdminPagina'){echo "active";}  if(empty($_GET["page"])) {echo "active";}  ?>" id="a" onclick="location.href='index.php?page=formAdminPagina'">Admin Pagina</a>
                    </li>
                    <li>
                        <a style="cursor:pointer;" class="nav_a  <?php if ($_GET["page"] == 'productenBeherenForm'){echo "active";}?>" id="a" onclick="location.href='index.php?page=productenBeherenForm'">Producten beheren</a>
                    </li>
                    <li>
                        <a style="cursor:pointer;" class="nav_a  <?php if ($_GET["page"] == 'bestellingenBeherenForm'){echo "active";}?>" id="a" onclick="location.href='index.php?page=bestellingenBeherenForm'">Bestellingen</a>
                    </li>
            </nav>
            <br><br><br>
            <?php
            $query = "SELECT * FROM ((artikel INNER JOIN categorie ON artikel.Categorie_ID = categorie.Categorie_ID) INNER JOIN verkoopwijze ON artikel.Verkoopwijze_ID = verkoopwijze.Verkoopwijze_ID)";
            $artikelen = $db->query($query);
            ?>
            <h2>Beheer alle Producten</h2>
            <table>
                <tr>
                    <th>Afbeelding</th>
                    <th>Naam</th>
                    <th>Categorie</th>
                    <th>Prijs</th>
                    <th>In Onderhoud?</th>
                </tr>
                <?php
                foreach ($artikelen as $artikel) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $artikel["Image"];?>
                        </td>
                        <td>
                            <?php echo $artikel["Naam"];?>
                        </td>
                        <td>
                            <?php echo $artikel["Categorie_naam"];?>
                        </td>
                        <td>
                            <?php
                            $prijs = $artikel["Prijs"] / 60;
                            $afgerond = number_format($prijs, 2, '.', ',');
                            $komma = str_replace('.', ',', $afgerond);

                            echo $komma;
                            ?>
                        </td>
                        <td>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <select class="test" name="onderhoudWaarde" onchange='this.form.submit()'>
                                    <?php
                                        if ($artikel["Onderhoud"] == 1) {
                                            ?>
                                            <option value="1" selected>Niet in Onderhoud</option>
                                            <?php
                                        } else {
                                            ?>
                                            <option value="2" selected>In Onderhoud</option>
                                            <?php
                                        }
                                    ?>
                                    <option value="2">In Onderhoud</option>
                                    <option value="1">Niet in Onderhoud</option>
                                </select>
                                <noscript><input type="submit" value="submit"></noscript>
                                <input type="hidden" name="inOnderhoud" value="true">
                                <input type="hidden" name="productID" value="<?php echo $artikel["ID"]; ?>">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
<?php
}else {
    echo "
  <script>
    alert('U moet ingelogd zijn om deze pagina te bekjijken.');
    location.href='index.php?page=home';
  </script>
  ";
}
?>

