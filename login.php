<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- // logo section -->
        <div class="d-flex justify-content-center justify-items-center w-50 m-auto">
            <a href="index.php">
            <img src="assets/images/logo.png" alt="logo" class="img-fluid">
            </a>
        </div>
        <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
           $nid = $_POST["nid_card"];
            require_once "database.php";
            
            // Check if NID exists in the database
            $sql_nid_check = "SELECT * FROM users WHERE nid_card = '$nid'";
            $result_nid_check = mysqli_query($conn, $sql_nid_check);
            $nid_exists = mysqli_num_rows($result_nid_check) > 0;
            
            if ($nid_exists) { // NID exists in the database
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if ($user) {
                    if (password_verify($password, $user["password"])) {
                        session_start();
                        $_SESSION["user"] = "yes";
                        header("Location: index.php");
                        die();
                    }else{
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                }else{
                    echo "<div class='alert alert-danger'>Email does not match</div>";
                }
            } else { // NID does not exist in the database
                echo "<div class='alert alert-danger'>Invalid NID number</div>";
            }
        }
        ?>
      <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" placeholder="johndoe@example.com" required>
        </div>
        <div class="form-group">
            <label for="email">NID Card Number:</label>
            <input type="text" class="form-control" name="nid_card" placeholder="1971XXXXXXXXXXXXX" required>
        </div>        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="***********" required>
        </div>
        <div class="form-btn">
            <input type="submit" class="btn" style="background-color:#9d0858;color:#ffffff" value="Register" name="submit">
        </div>
      </form>
     <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>
