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
            <div class="containerAdmin">
                <form class="adminFrom1" method="POST" enctype="multipart/form-data" action="pages/LijstenGenererenForm.php">
                    <h2>Lijsten</h2>
                    <div class="row">
                        <select class="test" name="waarde" required>
                            <option value="0" selected>Selecteer een lijst</option>
                            <option value="1">Lijst Bezorgers</option>
                            <option value="2">Lijst Ophalen</option>
                        </select>
                        <input type="hidden"  name="submit_lijst" value="true" />
                        <input  class="prod-button" type="submit" id="submit" value=" Download Lijst " /><br>
                    </div>
                </form>

<!--                <form method="post" action="pages/LijstenGenererenForm.php">-->
<!--                    <input type="submit" name="export" class="btn btn-success" value="Export" />-->
<!--                </form>-->
            </div>
            <div class="containerAdmin">
                <form class="adminFrom1" method="POST" enctype="multipart/form-data" action="">
                    <h2>Geeft korting</h2>
                    <div class="row">
                        <input type="email" name="email" placeholder="email adres"/>
                        <input type="number" name="korting" placeholder="5" min="5" max="100"/>
                        <input type="hidden"  name="submit_korting" value="true" />
                        <input  class="prod-button" type="submit" id="submit" value=" Voeg toe " /><br>
                    </div>
                </form>
            </div>
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

