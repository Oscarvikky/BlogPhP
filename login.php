<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = addslashes($_POST['email']);
    $username = addslashes($_POST['password']);
    $date = date('Y-m-d H:i:s');

    $query = "SELECT * FROM `users_tb` WHERE email = '$email' && password = '$password'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['info'] = $row;
        header("location: profile.php");
        die();
    } else {
        $error = "wrong email or password";
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include "header.php" ?>
    <div>
        <?php
        if (!empty($error)) {
            echo "<div>" . $error . "</div>";
        }
        ?>
        <h2 style="text-align: center">Login</h2>
        <form action="" method="post" style="margin: auto; padding: 10px ">

            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <button>Login</button>

        </form>
    </div>
    <?php include "footer.php" ?>
</body>

</html>