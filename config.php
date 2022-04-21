<?php
define('DB_SERVER', 'enter-server-name-here');
define('DB_USERNAME', 'enter-username-here');
define('DB_PASSWORD', 'enter-password-here');
define('DB_NAME', 'enter-database-name-here');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($mysqli === false){
    die("ERROR: Could not Connect. " . $mysqli->conect_error);
   
}
?>