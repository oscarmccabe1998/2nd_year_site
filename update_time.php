<?php
require_once "config.php";
$updated_song_name = $updated_song_name_err = "";
            $updated_start_time = $updated_start_time_err = "";
            $entry_err = $entry = "";

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty(trim($_POST["id"]))){
                    $entry_err = "You need to enter number to the left of the song";

                } else {
                    $entry = trim($_POST["id"]);
                }

                if(empty(trim($_POST["updated_start_time"]))){
                    $updated_start_time_err = "Please enter the new song name";

                } else {
                    $updated_start_time = trim($_POST["updated_start_time"]);
                }

                if(empty($entry_err) && empty($updated_start_time_err)){
                    $sql = "UPDATE set_list SET song_start_time = ? WHERE entry_id = ?";

                    if ($stmt = $mysqli->prepare($sql)){
                        $stmt->bind_param("si", $updated_start_time, $entry);

                        if($stmt->execute()){
                            
                            session_destroy();
                            header("location: login.php");
                            exit();
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
            
                        
                        $stmt->close();
                    }
                }
            }
            $mysqli->close();
            ?>