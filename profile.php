<?php
require "functions.php";

check_login();


if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'delete') {
    // delete user profile
    $id = $_SESSION['info']['id'];
    $query = "DELETE FROM `users_tb` WHERE `id` = '$id' limit 1";
    $result = mysqli_query($con, $query);

    if (file_exists($_SESSION['info']['image'])) {
        unlink($_SESSION['info']['image']);   // to delete existed image or file 
    }

    header("location: logout.php");
    die();
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['username'])) {
    // edit profile
    $image_added = false;   // this check to know if image added   
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        //file uploaded
        $folder = "uploads/";

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);  // this help to create folder or file, 0777 and true is permission params  and dy are constant
        }
        $image = $folder . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        if (file_exists($_SESSION['info']['image'])) {
            unlink($_SESSION['info']['image']);   // to delete existed image or file 
        }
        $image_added = true;
    }

    $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $username = addslashes($_POST['password']);
    $id = $_SESSION['info']['id'];

    if ($image_added == true) {
        $query = "UPDATE `users_tb` SET `username` = '$username',`email` = '$email', `password` = '$password', `image`= '$image' WHERE `id` = '$id' limit 1";
    } else {
        $query = "UPDATE `users_tb` SET `username` = '$username',`email` = '$email', `password` = '$password' WHERE `id` = '$id' limit 1";
    }

    $result = mysqli_query($con, $query);

    $query = "SELECT * FROM `users_tb` WHERE `id` = '$id' limit 1";
    $result2 = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['info'] = mysqli_fetch_assoc($result);
    }




    header("location: profile.php");
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

            <?php elseif (empty($_GET['action']) && $_GET['action'] == 'delete'): ?>
                <h2 style="text-align: center">Are you sure </h2>
                <form action="" method="post" style="margin: auto; padding: 10px ">
                    <div style="margin: auto; max-width: 600px; text-align: center;">

                        <img src="<?php echo $_SESSION['info']['username'] ?>" alt="" style="width: 100px; height: 100px; object-fit: cover; margin: auto; display: block;">

                        <div <?php echo $_SESSION['info']['username'] ?>> </div>
                        <div <?php echo $_SESSION['info']['email'] ?>> </div>


                        <button>delete</button>
                        <a href="profile.php">
                            <button type="button">Cancel</button>
                        </a>
                </form>
        </div>
    <?php else: ?>
        <h2 style="text-align: center"> User profile</h2> <br>

        <div style="margin: auto; max-width: 600px; text-align: center;">
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
            <a href="profile.php?action=edit"><button>Delete profile</button></a>

        </div>


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