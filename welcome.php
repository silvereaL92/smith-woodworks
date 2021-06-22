<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ background-color: #fbeec1; font: 14px sans-serif; text-align: center; }
        #maintitle { padding-top: 50px; font-family: "Raleway", sans-serif; font-size: 50px; text-decoration: none; color: black; }
    </style>
</head>
<body>
<center>
<a href="index.php" id="maintitle"><b>Smith Woodworks</a></b></center>
    <div class="page-header">
        <h1>Üdvözöljük, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>!</h1>
    </div>
    <a href="index.php">Főoldal! </a>
</body>
</html>