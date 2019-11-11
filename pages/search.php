
<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'feestfabriek';
//  connect met de database
    $db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
    //get search term
    $searchTerm = $_GET['term'];
//  haalt gegevens op volgens de query
    $query = $db->query("SELECT * FROM klant WHERE Email LIKE '%".$searchTerm."%' ORDER BY Email ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['Email'];
    }
//  geeft data terug
    echo json_encode($data);
?>