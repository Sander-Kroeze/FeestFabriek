<?php
if (isset($_SESSION["ID"])) {
    ?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
        $(function() {
            $( "#email" ).autocomplete({
                source: 'pages/search.php'
            });
        });
    </script>

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
                <form class="adminFrom1" method="POST" enctype="multipart/form-data" action="pages/LijstenGenererenForm.php" autocomplete="on">
                    <h2>Lijsten</h2>
                    <div class="row">
                        <select class="test" name="waarde" required>
                            <option value="0" selected>Selecteer een lijst</option>
                            <option value="1">Lijst Bezorging & Retours</option>
                            <option value="2">Lijst Afhalen & Terugbrengen</option>
                        </select>
                        <input type="hidden"  name="submit_lijst" value="true" />
                        <input  class="prod-button" type="submit" id="submit" value=" Download Lijst " /><br>
                    </div>
                </form>
            </div>
            <div class="containerAdmin">
                <form class="adminFrom1" method="POST" enctype="multipart/form-data" action="">
                    <h2>Geeft korting</h2>
                    <div class="row">
                        <input type="email" name="email" id="email" placeholder="Vul een klant email in">
                        <input type="number" name="korting" placeholder="5" min="5" max="100"/>
                        <input type="hidden"  name="submit_korting" value="true" />
                        <input  class="prod-button" type="submit" id="submit" value=" Voeg toe " /><br>
                    </div>
                </form>
                <ul class="list-gpfrm" id="hdTuto_search"></ul>
            </div>
        </div>
    </div>
<?php
} else {
    echo "
  <script>
    alert('U moet ingelogd zijn om deze pagina te bekjijken.');
    location.href='index.php?page=home';
  </script>
  ";
}
?>

