<?php
//Adatbazishoz csatlakozas
require_once 'db_connect.php';

if (!($con = connect()))
    die("Hiba" . mysqli_connect_error());
// Kello valtozok deklaralasa es inicializalasa
$username = $password = $confirm_password = $fname = $lname = $email = $cnp = $country = $city = $address = "";
$fname_err = $lname_err = $email_err = $cnp_err = $country_err = $city_err = $address_err = $username_err = $password_err = $confirm_password_err = "";

//Formbol az adatok feldolgozasa
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Kérem írjon be egy felhasználónevet.";
    } else{
        $sql = "SELECT id FROM user WHERE username = ?";
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            
            //foglalt-e a felhasznalonev
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "A felhasználónév már foglalt.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                die("Valami probléma merült fel, kérjük próbálja meg később." . mysqli_connect_error());
            }
        }
        else
            die("Valami probléma merült fel, kérjük próbálja meg később." . mysqli_connect_error());
         
        //stmt bezarasa
        mysqli_stmt_close($stmt);
    }
    
    // jelszo vizsgalata
    if(empty(trim($_POST['password']))){
        $password_err = "Kérjük írjon be egy jelszót!";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "A jelszónak legalább 6 karaktert kell tartalmaznia!";
    } else{
        $password = trim($_POST['password']);
    }

    //keresztnev vizsgalata
    if(empty(trim($_POST["fname"]))){
        $fname_err = "Kérjük írja be a keresztnevét.";     
    } else{
        $fname = trim($_POST["fname"]);
    }    

    //vezeteknev vizsgalata
    if(empty(trim($_POST["lname"]))){
        $lname_err = "Kérjük írja be a vezeteknevét.";     
    } else{
        $lname = trim($_POST["lname"]);
    }

    //email vizsgalata
    if(empty(trim($_POST["email"]))){
        $email_err = "Kérjük írja be az email címét.";
    } else{
        $sql = "SELECT id FROM user WHERE email = ?";
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Ez az email foglalt!.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Valami probléma merült fel! Kérjük próbálja meg később.";
            }
        }
        mysqli_stmt_close($stmt);
    }

    //cnp
    if(empty(trim($_POST["cnp"]))){
        $cnp_err = "Kérjük írja be a cnp-jét.";     
    } elseif (strlen(trim($_POST["cnp"])) != 13){
        $cnp_err = "Valós cnp-t írjon!";
        $cnp = trim($_POST["cnp"]);
    }

    //orszag
    if(empty(trim($_POST["country"]))){
        $country_err = "Kérjük írja be az országot.";     
    } else{
        $country = trim($_POST["country"]);
    }

    //varos
    if(empty(trim($_POST["city"]))){
        $city_err = "Kérjük írja be a várost.";     
    } else{
        $city = trim($_POST["city"]);
    }

    //cim
    if(empty(trim($_POST["address"]))){
        $address_err = "Kérjük írja be a lakcímét.";     
    } else{
        $address = trim($_POST["address"]);
    }

    //jelszo megerositese
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Kérjük írja be a jelszót';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'A két jelszó nem azonos.';
        }
    }
    
    //ha valami baj vane
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($fname_err) && empty($lname_err) && empty($email_err) && empty($cnp_err) && empty($country_err) && empty($city_err) && empty($address_err)) {
        
        $sql = "INSERT INTO user (username, password, fname, lname, email, CNP, Country, City, Address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_username, $param_password, $param_fname, $param_lname, $param_email, $param_cnp, $param_country, $param_city, $param_address);
            
            //parameterek beallitasa
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_fname = $fname;
            $param_lname = $lname;
            $param_email = $email;
            $param_cnp = $cnp;
            $param_country = $country;
            $param_city = $city;
            $param_address = $address;
            
            //ha minden patent
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
            } else{
                die ("Something went wrong. Please try again later." . mysqli_connect_error());
            }
        } else {
                die ("Something went wrong. Please try again later." . mysqli_connect_error());
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ background-color : #fbeec1; font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        #maintitle { padding-top: 50px; font-family: "Raleway", sans-serif; font-size: 50px; text-decoration: none; color: black; }
    </style>
</head>
<center>
<a href="index.php" id="maintitle"><b>Smith Woodworks</a></b></center>
<body>
    <div class="wrapper">
        <h2>Regisztracio</h2>
        <p>Kerem, toltse ki az alabbi ivet a regisztraciohoz!</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group <?php echo (!empty($fname_err)) ? 'has-error' : ''; ?>">
                <label>Keresztnev</label>
                <input type="text" name="fname"class="form-control" value="<?php echo $fname; ?>">
                <span class="help-block"><?php echo $fname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($lname_err)) ? 'has-error' : ''; ?>">
                <label>Vezeteknev</label>
                <input type="text" name="lname"class="form-control" value="<?php echo $lname; ?>">
                <span class="help-block"><?php echo $lname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>E-mail cim</label>
                <input type="text" name="email"class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($cnp_err)) ? 'has-error' : ''; ?>">
                <label>CNP</label>
                <input type="text" name="cnp"class="form-control" value="<?php echo $cnp; ?>">
                <span class="help-block"><?php echo $cnp_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                <label>Orszag</label>
                <input type="text" name="country"class="form-control" value="<?php echo $country; ?>">
                <span class="help-block"><?php echo $country_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>Telepules</label>
                <input type="text" name="city"class="form-control" value="<?php echo $city; ?>">
                <span class="help-block"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Lakcim</label>
                <input type="text" name="address"class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Már van fiókja? <a href="login.php">Jelentkezzen be itt!</a>.</p>
        </form>
    </div>    
</body>
</html>