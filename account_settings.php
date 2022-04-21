<?php
include 'checklogin.php';
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
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
	
</head>
<body>
<?php
include 'navbar.html';
?>
<br>
<br>
<h3>Manage your account</h3>
<br>
<br>
<div class="container">
    <div class="row">
        <div class= "col-sm-6">
            <h3>Update password</h3>
            <div class="wrapper">
        
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>  
        </div>
        <div class= "col-sm-6">
            <h3>Delete Account</h3>
            <p>If you are not happy using the site feel free to click the button below to delete your account. Once you have deleted your account none of the information you have provided will be stored on our servers from that point on to ensure we comply with GDPR.</p>
            <div class="container">
                <div class="row">
                    <div class="col text-center">
            <div class="form-group">
                
                    <form action="delete_account.php">
                        <input type="submit" class="btn btn-primary" value="Delete Account">
                    </form>
                    </div>
                </div>
</div>
                
            </div>
        </div>
    
    <div class= "col-sm-12">
            <h3>GDPR compliance</h3>
            <p>If you choose to continue to use this website. The only information held on our servers is from the data you provide us. We only use essential data to ensure the site runs in the way it was intended. If you decide you no longer want to use our site and delte your account all the personal information will be deleted from our servers. Any information you have posted to the site can be changed or deleted by you at any point. For any further questions email us at 1603127@uad.ac.uk</p>
            <p>All your data that is held on our website is stored safely and securely. If we lose any data we will be fined by the Information Commisioner</p>
            <p>We do not currently run any adverts so we dont use or have any need to use your information to targer adverts towards you. If this changes at any point we will inform you and allow you to opt out</p>
            <h3>Use of cookies</h3>
            <p>For our website we only make use of essential cookies to ensure that a user has been validated properly through the use of seesions. This is to make sure that your personal information is safe and secure. Due to the use of cookies on this service being essential towards functionality there is no way for us to allow you to reject them. If you disagree with this you can delete your account and all your personal information will be wiped from our servers</p>  


        </div>
    </div>

</div>
<footer>
<a href="req.html">Requirement's page</a>
</footer>
</body>
</html>