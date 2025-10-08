<?php
require "functions.php";

check_login();


if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'post_delete') {
    // delete your post
    $id = $_GET['id'] ?? 0;
    $user_id = $_SESSION['info']['id'];
    $query = "SELECT * FROM `post` WHERE `id` = '$id' && `user_id` = '$user_id' limit 1";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (file_exists($row['image'])) {
            unlink($row['image']);
        }
    }
    $query = "DELETE FROM `post` WHERE `id` = '$id' && `user_id` = '$user_id' limit 1";
    $result = mysqli_query($con, $query);
    header("location: profile.php");
    die();
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && !empty($_POST['action']) == "post_edit") {
    // edit your post
    $id = $_GET['id'] ?? 0;
    $user_id = $_SESSION['info']['id'];
    $image_added = false;
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0 && $_FILES['image']['type'] == 'image/jpeg') {

        $folder = "uploads/";  // create folder for storing uploaded images
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $image = $folder . $_FILES['image']['name'];

        (move_uploaded_file($_FILES['image']['tmp_name'], $image));


        // Delete old image only if it exists
        $query = "SELECT * FROM `post` WHERE `id` = '$id' && `user_id` = '$user_id' limit 1";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (file_exists($row['image'])) {
                unlink($row['image']);
            }
        }

        $image_added = true;
    }

    // Prepare other values
    $post = addslashes($_POST['post']);
    $id = $_SESSION['info']['id'];

    // Build the correct SQL query
    if ($image_added) {
        $query = "UPDATE `post` 
                  SET `post` = '$post',
    
                      `image` = '$image'
                  WHERE `id` = '$id' && `user_id` = '$user_id' LIMIT 1";
    } else {
        $query = "UPDATE `post` 
                  SET `post` = '$post',
                      
                  WHERE `id` = '$id' && `user_id` = '$user_id' LIMIT 1";
    }

    // Execute the query
    $result = mysqli_query($con, $query);

    header("Location: profile.php");
    die;
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['action']) && $_POST['action'] == 'delete') {
    // delete user profile
    $id = $_SESSION['info']['id'];
    $query = "DELETE FROM `users_tb` WHERE `id` = '$id' limit 1";
    $result = mysqli_query($con, $query);

    if (!empty($_SESSION['info']['image']) && file_exists($_SESSION['info']['image'])) {
        unlink($_SESSION['info']['image']);
    }
    $query = "DELETE FROM `post` WHERE `user_id` = '$id'";
    $result = mysqli_query($con, $query);


    header("location: logout.php");
    die();
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['username'])) {
    // edit profile
    $image_added = false;
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0 && $_FILES['image']['type'] == 'image/jpeg') {

        $folder = "uploads/";  // create folder for storing uploaded images
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $image = $folder . $_FILES['image']['name'];

        (move_uploaded_file($_FILES['image']['tmp_name'], $image));


        // Delete old image only if it exists
        if (file_exists($_SESSION['info']['image'])) {
            unlink($_SESSION['info']['image']);
        }

        $image_added = true;
    }

    // Prepare other values
    $username = addslashes($_POST['username']);
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);
    $id = $_SESSION['info']['id'];

    // Build the correct SQL query
    if ($image_added) {
        $query = "UPDATE `users_tb` 
                  SET `username` = '$username',
                      `email` = '$email',
                      `password` = '$password',
                      `image` = '$image'
                  WHERE `id` = '$id' LIMIT 1";
    } else {
        $query = "UPDATE `users_tb` 
                  SET `username` = '$username',
                      `email` = '$email',
                      `password` = '$password'
                  WHERE `id` = '$id' LIMIT 1";
    }

    // Execute the query
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "Database Error: " . mysqli_error($con);
        exit;
    }

    // Update session with latest user data
    $query = "SELECT * FROM `users_tb` WHERE `id` = '$id' LIMIT 1";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['info'] = mysqli_fetch_assoc($result);
    }

    header("Location: profile.php");
    die;
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['post'])) {
    // adding post
    // $image_added = false;   // this check to know if image added   
    $image = "";
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0 && $_FILES['image']['type'] == 'image/jpeg') {
        $folder = "uploads/";  // create folder for storing uploaded images
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $image = $folder . $_FILES['image']['name'];
        (move_uploaded_file($_FILES['image']['tmp_name'], $image));
    }

    $post = addslashes($_POST['post']);
    $user_id = $_SESSION['info']['id'];
    $date = date('Y-m-d H:i:s');

    $query = "INSERT INTO `post` (`user_id`, `post`, `image`,`date`) VALUES('$user_id', '$post', '$image', '$date')";

    $result = mysqli_query($con, $query);
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
            <?php if (isset($_GET['action']) && $_GET['action'] == 'post_delete' && !empty($_GET['id'])): ?>


                <?php
                $id = (int)$_GET['id'];
                $query = "SELECT * FROM `post` WHERE `id`='$id' limit 1";
                $result = mysqli_query($con, $query);





                ?>




                <?php if (mysqli_num_rows($result) > 0): ?>
                    <h3 style="margin-top: 30px;"> Are you sure?</h5> <br>
                        <form action="" enctype="multipart/form-data" method="post" style="margin: auto; padding: 10px ">
                            <img src="<?= $row['image'] ?>" alt="" style="width: 100%; height: 250px; object-fit: cover; display:block"><br>

                            <div name="post" rows="8"><?= $row['post'] ?></div> <br>
                            <input type="hidden" name="action" value="post_delete">

                            <button>Delete</button>
                            <a href="profile.php">
                                <button type="button">Cancel</button>
                            </a>

                        </form>
                    <?php endif ?>

                <?php elseif (isset($_GET['action']) && $_GET['action'] == 'post_edit' && !empty($_GET['id'])): ?>


                    <?php
                    $id = (int)$_GET['id'];
                    $query = "SELECT * FROM `post` WHERE `id`='$id' limit 1";
                    $result = mysqli_query($con, $query);





                    ?>




                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <h5 style="margin-top: 30px;"> Edit a post</h5> <br>
                        <form action="" enctype="multipart/form-data" method="post" style="margin: auto; padding: 10px ">
                            <img src="<?= $row['image'] ?>" alt="" style="width: 100%; height: 250px; object-fit: cover; display:block"><br>
                            image: <input type="file" name="image" id="">
                            <textarea name="post" rows="8"><?= $row['post'] ?></textarea> <br>
                            <input type="hidden" name="action" value="post_edit">

                            <button>Save</button>
                            <a href="profile.php">
                                <button type="button">Cancel</button>
                            </a>

                        </form>
                    <?php endif ?>









                <?php elseif (isset($_GET['action']) && $_GET['action'] == 'edit'): ?>

                    <h2 style="text-align: center">edit profile</h2>
                    <form action="" method="post" enctype="multipart/form-data" style="margin: auto; padding: 10px ">
                        <img src="<?php echo $_SESSION['info']['image'] ?>" alt="" style="width: 100px; height: 100px; object-fit: cover; margin: auto; display: block;">
                        image: <input type="file" name="image">
                        <input value="<?php echo $_SESSION['info']['username'] ?>" type="text" name="username">
                        <input value="<?php echo $_SESSION['info']['email'] ?>" type="email" name="email">
                        <input value="<?php echo $_SESSION['info']['password'] ?>" type=" password" name="password">

                        <button>Save</button>
                        <a href="profile.php">
                            <button type="button">Cancel</button>
                        </a>
                    </form>
                <?php elseif (isset($_GET['action']) && $_GET['action'] == 'delete'): ?>
                    <h2 style="text-align: center">Are you sure </h2>
                    <div style="margin: auto; max-width: 600px; text-align: center;">

                        <form action="" method="post" style="margin: auto; padding: 10px ">

                            <img src="<?php echo $_SESSION['info']['username'] ?>" alt="" style="width: 100px; height: 100px; object-fit: cover; margin: auto; display: block;">

                            <div <?php echo $_SESSION['info']['username'] ?>> </div>
                            <div <?php echo $_SESSION['info']['email'] ?>> </div>
                            <input type="hidden" name="action" value="delete">


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
                            <td><img src="<?php echo $_SESSION['info']['image'] ?>" alt="" style="width: 150px; height: 150px; object-fit: cover;"> </td>
                        </div>
                        <div>
                            <td><?php echo $_SESSION['info']['username'] ?></td>
                        </div>
                        <div>
                            <td><?php echo $_SESSION['info']['email'] ?></td>
                        </div>
                        <a href="profile.php?action=edit"><button>Edit profile</button></a>
                        <a href="profile.php?action=delete"><button>Delete profile</button></a>

                    </div>


        </div>
        <br>
        <hr>
        <h5 style="margin-top: 30px;">Create a post</h5> <br>
        <form action="" enctype="multipart/form-data" method="post" style="margin: auto; padding: 10px ">
            image: <input type="file" name="image" id="">
            <textarea name="post" rows="8"></textarea> <br>

            <button>Post</button>

        </form>

        <hr>
        <div>
            <?php
                $id = $_SESSION['info']['id'];
                $query = "SELECT * FROM `post` WHERE `user_id` = '$id' ORDER BY `id` DESC";
                $result = mysqli_query($con, $query)


            ?>





            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                        $user_id = $row['user_id'];
                        $query = "SELECT `username`, `image` FROM `users_tb` WHERE `id` = '$user_id' limit 1 ";
                        $result2 = mysqli_query($con, $query);
                        $user_row = mysqli_fetch_assoc($result2)

                    ?>
                    <div style="display: flex; border:solid thin #aaa; border-radius:20px; margin-bottom:12px; margin-top:12px;">
                        <div style="flex:1; text-align:center; margin:15px;">
                            <img src="<?= $user_row['image'] ?>" alt="" style=" border-radius: 50%; width:100px;  height:100px; object:fit">
                            <br>
                            <?= $user_row['username'] ?>

                        </div>
                        <div style="flex: 8; display: flex; flex-direction: column; gap: 10px;">

                            <?php if (file_exists($row['image'])): ?>
                                <div>
                                    <img src="<?= $row['image'] ?>" alt="" style="width: 100%; height: 250px; object-fit: cover; display:block">
                                </div>
                            <?php endif; ?>

                            <div>
                                <div>
                                    <?= nl2br(htmlspecialchars($row['post'])) ?>
                                </div>
                                <div style="color: #888; font-size:8px">
                                    <?= date("jS, M, Y", strtotime($row['date'])) ?>
                                </div>
                                <br>

                                <a href="profile.php?action=post_edit &id= <?= $row['id'] ?>"><button>Edit</button></a>
                                <a href="profile.php?action=post_delete &id=  <?= $row['id'] ?> "><button>Delete</button></a>
                            </div>
                            <br>

                        </div>

                    </div>

                <?php endwhile ?>

            <?php endif; ?>
        </div>
    <?php endif ?>
    </div>
    <?php include "footer.php" ?>
</body>

</html>