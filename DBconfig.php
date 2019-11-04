<?php
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
