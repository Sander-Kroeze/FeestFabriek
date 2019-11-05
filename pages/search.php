
<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'feestfabriek';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
//get search term
$searchTerm = $_GET['term'];
//get matched data from skills table
$query = $db->query("SELECT * FROM klant WHERE Email LIKE '%".$searchTerm."%' ORDER BY Email ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['Email'];
}
//return json data
echo json_encode($data);
?>