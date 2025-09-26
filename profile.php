<?php
require "functions.php";

check_login();
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
        <table>
            <tr>
                <td><img src="img.jpg" alt="" style="width: 150px; height: 150px; object-fit: cover;"> </td>
            </tr>
            <tr>
                <td><?php echo $_SESSION['info']['username'] ?></td>
            </tr>
            <tr>
                <td><?php echo $_SESSION['info']['email'] ?></td>
            </tr>
        </table>
        <hr>
        <h5 style="margin-top: 30px;">Create a post</h5> <br>
        <form action="" method="post" style="margin: auto; padding: 10px ">

            <textarea name="post" rows="8"></textarea> <br>

            <button>Post</button>

        </form>
    </div>
    <?php include "footer.php" ?>
</body>

</html>