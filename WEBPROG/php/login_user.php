<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: user_dashboard.php");
}

if (isset($_POST["login"])) {
    $Email = $_POST["Email"];
    $password = $_POST["password"];
    require_once "database_user.php";
    $sql = "SELECT * FROM tbl_user WHERE EMAIL_ADD = '$Email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($user) {
        if (password_verify($password, $user["PASSWORD"])) {
            $_SESSION["user_id"] = $user["USER_ID"];
            $_SESSION["user"] = "yes";
            
            // Regenerate session ID for security
            session_regenerate_id(true);

            // Debugging statements
            echo "Session ID: " . session_id() . "<br>";
            echo "User ID: " . $_SESSION["user_id"] . "<br>";

            header("Location: user_dashboard.php");
            die();
        }
    } else {
        echo "<div class='alert alert-danger'>Email does not match</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="login_user.css">
</head>
<body>
    <div class="container">
        <?php
            if (isset($_POST["login"])) {
                $Email = $_POST["Email"];
                $password = $_POST["password"];
                require_once "database_user.php";
                $sql = "SELECT * FROM tbl_user WHERE EMAIL_ADD = '$Email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if ($user) {
                    if (password_verify($password, $user["PASSWORD"])) {
                        $_SESSION["user_id"] = $user["USER_ID"];
                        $_SESSION["user"] = "yes";
                        
                        // Regenerate session ID for security
                        session_regenerate_id(true);

                        header("Location: user_dashboard.php");
                        die();
                    } else {
                        echo "<div class='alert alert-danger'>Incorrect password</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Email does not match</div>";
                }
            }
        ?>

        <form action="login_user.php" method="post">
            <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" name="Email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>

        <div><p style= "color: white;">Not Registered yet? <a style = "color: #329C4E;"href="registration_user.php">Register Here</a></p></div>
    </div>
</body>
</html>
