<?php
//start de session
session_start();
$_SESSION["STATUS"] = 0;
// include andere bestanden
include_once("DBconfig.php");
include_once("header.php");
if(isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = "home";
}
?>


<div class="content-all-pages">
<?php
if($page) {
    include("pages/".$page.".php");
}

?>
</div>
<?php
include_once("footer.php");