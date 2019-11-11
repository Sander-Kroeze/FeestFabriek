<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FFF</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans&display=swap" rel="stylesheet">
</head>
<body>
<div class="main">
    <nav class="navigation">
        <ul>
            <li>
                <img style="cursor: pointer" width="55px" src="img/logo_transparent.png" onclick="window.open('index.php?page=home')">
            </li>
            <li>
                <a style="cursor:pointer;" class="nav_a <?php if ($_GET["page"] == 'home'){echo "active";}  if(empty($_GET["page"])) {echo "active";}  ?>" id="a" onclick="location.href='index.php?page=home'">Home</a>
            </li>
            <li>
                <a style="cursor:pointer;" class="nav_a  <?php if ($_GET["page"] == 'producten'){echo "active";}?>" id="a" onclick="location.href='index.php?page=producten'">Producten</a>
            </li>
            <li>
                <a style="cursor:pointer;" class="nav_a  <?php if ($_GET["page"] == 'contact'){echo "active";}?>" id="a" onclick="location.href='index.php?page=contact'">Contact</a>
            </li>
            <?php
                if (isset($_SESSION["ID"])) {

                ?>
                <li style="cursor:pointer;" class="nav_a">
                    <a style="cursor:pointer;" class="nav_a  <?php if ($_GET["page"] == 'login'){echo "active";}?>" id="a" onclick="location.href='index.php?page=uitloggen'"><i class="fas fa-power-off"></i></a>
                </li>
                <?php
                } else {
                    ?>
                <li style="cursor:pointer;" class="nav_a">
                    <a style="cursor:pointer;" class="nav_a  <?php if ($_GET["page"] == 'login'){echo "active";}?>" id="a" onclick="location.href='index.php?page=inlogForm'"><i class="fas fa-user"></i></a>
                </li>
            <?php
                }
            ?>
    </nav>
</div>

