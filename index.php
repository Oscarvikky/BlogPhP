<?php
require "functions.php";

check_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div style="max-width:600px; margin:auto;">
        <h3 style="text-align: center;">Timeline</h3>
        <?php
        $id = $_SESSION['info']['id'];
        $query = "SELECT * FROM `post` WHERE `user_id` = '$id' ORDER BY `id` DESC";
        $result = mysqli_query($con, $query)


        ?>





        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                $user_id = $row['user_id'];
                $query = "SELECT `username`, `image` FROM `user_tb` WHERE `id` = '$user_id' limit 1 ";
                $result2 = mysqli_query($con, $query);
                $user_row = mysqli_fetch_assoc($result2)

                ?>
                <div style="display: flex; border:solid thin #aaa; border-radius:20px; margin-bottom:12px; margin-top:12px;">
                    <div style="flex:1; text-align:center;">
                        <img src="<?= $row['image'] ?>" alt="" style=" border-radius: 50%; width:100px; margin:12px height:100px; object:fit">
                        <br>
                        <?= $user_row['username'] ?>

                    </div>
                    <div style="flex:8">
                        <?php if (file_exists($row['image'])): ?>
                            <div">
                                <img src="<?= $row['image'] ?>" alt="" style="width:100%; height:200px; object:fit">
                    </div>
                <?php endif ?>
                <div>
                    <div style="color: #888;"><?php echo date("JS, M, Y ", strtotime($row['date'])) ?> </div>
                    <?php echo $row['post'] ?>
                </div>
                </div>
    </div>

<?php endwhile ?>

<?php endif; ?>
</div>
<?php include "footer.php"; ?>


</body>

</html>