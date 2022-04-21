<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "config.php";
echo "<br>";
for ($x = 1; $x <=14; $x++){
$sql = "SELECT location, availability FROM tickets WHERE id = ?";
$paramint = 1;
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $x);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($location, $availability);
$stmt->fetch();
$stmt->close();
$space = " ";
//echo "<table class='img-container'>";
//echo "<tr>";

//echo "<th>Location </th>";

//echo "<td>" .$location ."</td>";

//echo "<th> Availability </th>";

//echo "<td>" .$availability ."</td>";
//echo "</tr>";
//echo "</table>";
//echo "<p>";
echo "<h6>" . $location . $space . $availability . "</h6>";
//echo "<p>" . $availability . "</p>";

//echo "</p>"
}
$mysqli->close();
?>