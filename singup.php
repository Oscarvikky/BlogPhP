<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);
    $date = date('Y-m-d H:i:s');

    $query = "INSERT INTO `users_tb` (`username`,`email`,`password`,`date`) VALUES ('$username', '$email', '$password', '$date')";
    $result = mysqli_query($con, $query);
    header("location: login.php");
    die();
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
        <h2 style="text-align: center">Signup</h2>
        <form action="" method="post" style="margin: auto; padding: 10px ">
            <input type="text" name="username" placeholder="Username">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">

            <button>Signup</button>

        </form>
    </div>
    <?php include "footer.php" ?>
</body>

</html>