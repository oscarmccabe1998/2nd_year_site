<?php
require_once 'config.php';

// Initialize the session
session_start();

$sql = "DELETE FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("s", $param_id);
    $param_id = $_SESSION["id"];

    if($stmt->execute()){
        // Unset all of the session variables
        $_SESSION = array();
 
        // Destroy the session.
        session_destroy();
        // Redirect to login page
        header("location: login.php");
        exit;
    } else {
        echo "Something went wrong";
    }

    $stmt->close();
    $mysqli->close();
}


 





?>