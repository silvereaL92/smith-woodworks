<?php
require_once 'db_connect.php';
if (!($link = connect()))
    die("Hiba" . mysqli_connect_error());

$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT username, password FROM user WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                //ha van ilyen felhasznalonev
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        //ha megegyezik a jelszo
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION['username'] = $username;      
                            header("location: welcome.php");
                        } else{
                            $password_err = 'A jelszó hibás.';
                        }
                    }
                } else{
                    $username_err = 'Ilyen felhasználó nem létezik.';
                }
            } else{
                die("Oops! Something went wrong. Please try again later." . mysqli_connect_error());
            }
        }
        else
           die("Oops! Something went wrong. Please try again later." . mysqli_connect_error());   
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ background-color: #fbeec1; font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        #maintitle { padding-top: 50px; font-family: "Raleway", sans-serif; font-size: 50px; text-decoration: none; color: black; }
    </style>
</head>
<body>
<center>
<a href="index.php" id="maintitle"><b>Smith Woodworks</a></b></center>
    <div class="wrapper">
        <h2>Bejelentkezés</h2>
        <p>Bejelentkezéshez töltse ki az alábbi mezőket!</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Felhasználónév</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Jelszó</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Nincs még fiókja? <a href="register.php">Regisztráljon most!</a>.</p>
        </form>
    </div>    
</body>
</html>