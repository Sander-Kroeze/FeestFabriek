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
            $query = "SELECT * FROM ((orders INNER JOIN klant ON orders.Klant_ID = klant.ID INNER JOIN adres ON orders.Adres_ID = adres.adresID))";
            $orders = $db->query($query);
            ?>
            <h2>Beheer alle Orders</h2>
            <table>
                <tr>
                    <th>Order Nummer</th>
                    <th>Klant Naam</th>
                    <th>Bezorg Methode</th>
                    <th>Prijs</th>
                    <th>Betaal Status</th>
                    <th>Status</th>
                    <th>Factuur</th>
                </tr>
                <?php
                foreach ($orders as $order) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $order["orders_ID"];?>
                        </td>
                        <td>
                            <?php echo $order["Naam"] . ' ' . $order["Tussenvoegsel"]  .' ' . $order["Achternaam"] ;?>
                        </td>
                        <td>
                            <?php echo $order["BezorgOpties"] ;?>
                        </td>
                        <td>
                            <?php
                            $totaalKomma = str_replace('.', ',', $order["totaalPrijs"]);
                            echo '€ ' . $totaalKomma ;?>
                        </td>
                        <td>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <select class="test" name="betaalStatus" onchange='this.form.submit()'>
                                    <?php
                                    if ($order["BetaalStatus"] === 'Niet Betaald') {
                                        ?>
                                        <option value="Niet Betaald" selected>Niet Betaald</option>
                                        <option value="Betaald" >Betaald</option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="Betaald" selected>Betaald</option>
                                        <option value="Niet Betaald">Niet Betaald</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <noscript><input type="submit" value="submit"></noscript>
                                <input type="hidden" name="betaalStatusSet" value="true">
                                <input type="hidden" name="orderId" value="<?php echo $order["orders_ID"]; ?>">
                            </form>
                        </td>
                        <td>
                            <?php
                            $now = date("Y-m-d");
                            $test = $order["OrderDatum"];
                            $date1=date_create("$now");
                            $date2=date_create("$test");
                            $diff=date_diff($date1,$date2);
                            $verschil =  $diff->format("%R%a");
                            if( $verschil === '+1') {
                                echo $verschil;
                            } else {
                                echo $verschil;
                            }
                            ?>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <select class="test" name="bezorgStatus" onchange='this.form.submit()'>
                                    <?php
                                    if ($order["Retour"] === 'Retour') {
                                        ?>
                                        <option value="In Magazijn">In Magazijn</option>
                                        <option value="Onderweg">Onderweg</option>
                                        <option value="Bezorgd">Bezorgd</option>
                                        <option value="Retour" selected>Op Retour</option>
                                        <option value="Retour Bezorgd">Retour Bezorgd</option>
                                        <?php
                                    }  elseif ($order["Retour"] === 'Retour Bezorgd') {
                                        ?>
                                        <option value="Bezorgd">Bezorgd</option>
                                        <option value="Onderweg" >Onderweg</option>
                                        <option value="In Magazijn">In Magazijn</option>
                                        <option value="Retour">Op Retour</option>
                                        <option value="Retour Bezorgd" selected>Retour Bezorgd</option>
                                        <?php
                                    } elseif ($order["BezorgStatus"] === 'Magazijn') {
                                        ?>
                                        <option value="Bezorgd">Bezorgd</option>
                                        <option value="Onderweg" >Onderweg</option>
                                        <option value="In Magazijn" selected>In Magazijn</option>
                                        <option value="Retour">Op Retour</option>
                                        <option value="Retour Bezorgd">Retour Bezorgd</option>
                                        <?php
                                    } elseif ($order["BezorgStatus"] === 'Onderweg') {
                                        ?>
                                        <option value="Onderweg" selected>Onderweg</option>
                                        <option value="In Magazijn" >In Magazijn</option>
                                        <option value="Bezorgd">Bezorgd</option>
                                        <option value="Retour">Op Retour</option>
                                        <option value="Retour Bezorgd">Retour Bezorgd</option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="Bezorgd"selected>Bezorgd</option>
                                        <option value="Onderweg" >Onderweg</option>
                                        <option value="In Magazijn" >In Magazijn</option>
                                        <option value="Retour" >Op Retour</option>
                                        <option value="Retour Bezorgd">Retour Bezorgd</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <noscript><input type="submit" value="submit"></noscript>
                                <input type="hidden" name="bezorgStatusSET" value="true">
                                <input type="hidden" name="orderId" value="<?php echo $order["orders_ID"]; ?>">
                            </form>
                        </td>
                        <td>
                            <form method="post" enctype="multipart/form-data" action="pages/factuurGenereren.php">
                                <input type="hidden" name="orderId" value="<?php echo $order["orders_ID"]; ?>">
                                <input type="hidden" name="submit_download" value="true">
                                <input class="prod-button" type="submit" name="submit" value="Download" />
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

