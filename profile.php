<?php
require "functions.php";

check_login();


if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['username'])) {
    // edit profile
    $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $username = addslashes($_POST['password']);

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
    <title>Profile</title>
</head>

<body>
    <?php include "header.php" ?>
    <div>
        <h2 style="text-align: center"> User profile</h2>
        <div>
            <?php if (empty($_GET['action']) && $_GET['action'] == 'edit'): ?>
                <h2 style="text-align: center">edit profile</h2>
                <form action="" method="post" enctype="multipart/form-data" style="margin: auto; padding: 10px ">
                    <img src="<?php echo $_SESSION['info']['username'] ?>" alt="" style="width: 100px; height: 100px; object-fit: cover; margin: auto; display: block;">
                    image: <input type="file" name="image">
                    <input value="<?php echo $_SESSION['info']['username'] ?>" type="text" name="username" placeholder="Username" required>
                    <input value="<?php echo $_SESSION['info']['email'] ?> type=" text" name="email" placeholder="Email" required>
                    <input value="<?php echo $_SESSION['info']['password'] ?> type=" text" name="password" placeholder="Password" required>

                    <button>Save</button>
                    <a href="profile.php">
                        <button type="button">Cancel</button>
                    </a>
                </form>
            <?php else: ?>
                <div>
                    <td><img src="<?php echo $_SESSION['info']['username'] ?>" alt="" style="width: 150px; height: 150px; object-fit: cover;"> </td>
                </div>
                <div>
                    <td><?php echo $_SESSION['info']['username'] ?></td>
                </div>
                <div>
                    <td><?php echo $_SESSION['info']['email'] ?></td>
                </div>
                <a href="profile.php?action=edit"><button>Edit profile</button></a>
        </div>
        <br>
        <hr>
        <h5 style="margin-top: 30px;">Create a post</h5> <br>
        <form action="" method="post" style="margin: auto; padding: 10px ">

            <textarea name="post" rows="8"></textarea> <br>

            <button>Post</button>

        </form>
    <?php endif ?>
    </div>
    <?php include "footer.php" ?>
</body>

</html>