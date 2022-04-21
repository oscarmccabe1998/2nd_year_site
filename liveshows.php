<?php
include 'checklogin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Jamie Lenman</title>
	<meta name="description" content="Jamie Lenman fan site">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type ="text/css" href="custom.css">
    <link rel="stylesheet" type = "text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/Javascript" src="image.js"></script>
</head>
<body>
    
<?php
include 'navbar.html';
?>
<br>



<h3>Jamie Lenman's King of clubs tour</h3>
<br>
<p>Find out when and where Jamie Lenman is playing near you. As well as finding the set list for his current tour on this page here. </p>
<div id="import" class="img-container">

</div>
<p>Image taken from www.rocksins.com</p>
<br>
<div class="img_container">
    <div id="dates">
        <h3>Click the button blow to get the full list of tour dates for the King of clubs tour</h3><br>
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <button type="button" class="btn btn-primary" id="dates_button">Load tour dates</button>
                     </div>
                </div>
            </div>
        </div>
</div>
<br>
<div class="img_container">
<div class="col text-center">
<button id="showData" class="btn btn-primary">Show tickets availability</button>
<br>
<div class="container">
     <div class="row">
        <div class="col text-center">
            <div id="table-container"></div>
        </div>
    </div>
</div>
</div>
</div>
<br>
<br>
<h3>King of clubs tour set list</h3>
<br>
<div class="img-container">
<?php 
require_once "config.php";
ini_set('display_errors', 1);  
ini_set('display_startup_errors', 1);  
error_reporting(E_ALL);
$gig_info = 1;
$stmt = mysqli_prepare($mysqli, "SELECT entry_id, song_name, song_start_time FROM set_list WHERE ?");
mysqli_stmt_bind_param($stmt, "i", $gig_info);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $entry_id, $song_name, $song_start_time);
while (mysqli_stmt_fetch($stmt)) {
    printf ("%s %s %s <br />",$entry_id, $song_name, $song_start_time);
}
mysqli_stmt_close($stmt);
//mysqli_close($mysqli);
?>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <h2>Add set list entry</h2>
            <?php
            require_once "config.php";
            $song_name_entry = $song_start_time_entry ="";
            $song_name_entry_err = $song_start_time_entry_err ="";
            $sess_id = $_SESSION["id"];
            

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty(trim($_POST["song_name"]))){
                    $song_name_entry_err = "Please enter the name of the track.";
                } else {
                    $song_name_entry = trim($_POST["song_name"]);
                }

                if(empty(trim($_POST["start_time"]))){
                    $song_start_time_entry_err = "Please enter the start time of the track.";
                } else {
                    $song_start_time_entry = trim($_POST["start_time"]);
                }

                if(empty($song_name_entry_err) && empty($song_start_time_entry_err)){
                    $sql = "INSERT INTO set_list (song_name, song_start_time, userid) VALUES (?, ?, ?)";
                    
                    if($stmt = $mysqli->prepare($sql)){
                        $stmt->bind_param("ssi", $param_song_name, $param_song_start_time, $param_id);
                        //$stmt->bind_param("i", $userid);
                        $param_song_name = $song_name_entry;
                        $param_song_start_time = $song_start_time_entry;
                        $param_id = $sess_id;
                        

                        if($stmt->execute()){
                            header("location: liveshows.php");
                        } else {
                            echo"Something went wrong";
                        }
                        $stmt->close();
                        
                    }
                }
                
            }
            ?>
            
            <p>Please enter set list information</p>
            <br>
            <?php
            //echo $_SESSION["id"];

            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Song Name</label>
                <input type="text" name="song_name" class="form-control <?php echo (!empty($song_name_entry_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $song_name_entry; ?>">
                <span class="invalid-feedback"><?php echo $song_name_entry_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Song Start Time</label>
                <input type="text" name="start_time" class="form-control <?php echo (!empty($song_start_time_entry_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $song_start_time_entry; ?>">
                <span class="invalid-feedback"><?php echo $song_start_time_entry_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            </form>
            </div>
        
        <div class="col-sm-4">
            <h2>Update list entry</h2>
            <p>See a mistake? Ammend the song start time below</p>
            <?php 
            /*$stmt = mysqli_prepare($mysqli, "SELECT entry_id, song_name, song_start_time FROM set_list WHERE userid = ?");
            mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $entry_id, $song_name, $song_start_time);
            while (mysqli_stmt_fetch($stmt)) {
                printf ("%s %s %s <br />",$entry_id, $song_name, $song_start_time);
            }
            mysqli_stmt_close($stmt); */

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
                            
                           
                            echo'<script src="redirect.js"></script>';
                           
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
            
                        
                        $stmt->close();
                    }
                }
            }


            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Song ID</label>
                <input type="number" name="id" class="form-control <?php echo (!empty($song_name_entry_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $song_name_entry; ?>">
                <span class="invalid-feedback"><?php echo $song_name_entry_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Song Start Time</label>
                <input type="text" name="updated_start_time" class="form-control <?php echo (!empty($song_start_time_entry_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $song_start_time_entry; ?>">
                <span class="invalid-feedback"><?php echo $song_start_time_entry_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            </form>
            <?php
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
                                        
                                       
                            header("location: liveshows.php");
                                       
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                                    
                        $stmt->close();
                    }
                }
            }

            ?>
        </div>
        

            <?php
            $entry_err = $entry = "";
            
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty(trim($_POST["id1"]))){
                    $entry_err = "You need to enter number to the left of the song";
            
                } else {
                    $entry = trim($_POST["id1"]);
                }
                if(empty($entry_err)){
                    $sql = "DELETE FROM set_list WHERE entry_id = ?";
            
                    if ($stmt = $mysqli->prepare($sql)){
                        $stmt->bind_param("i",$entry);
            
                        if($stmt->execute()){
                                        
                                       
                            echo'<script src="redirect.js"></script>';
                                       
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        
                                    
                        $stmt->close();
                    }
                }
            }

            ?>
            <div class="col-sm-4">
            <h2>Delete post</h2>
            <p>Want to remove one of your post's? Just select the id number and we will remove it.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Song ID</label>
                <input type="number" name="id1" class="form-control <?php echo (!empty($entry_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $entry; ?>">
                <span class="invalid-feedback"><?php echo $entry_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            </form>


        </div>
    </div>
</div>
<?php
$mysqli->close();
?>
<script type="text/Javascript" src="dates.js"></script>
<script type="text/Javascript" src="tickets.js"></script>
<footer>
<a href="req.html">Requirement's page</a>
</footer>
</body>

</html>