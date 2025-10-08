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
    <div style="  max-width:500px; margin:auto;">
        <h3 style="text-align:center;">Timeline</h3>
        <?php

        $query = "SELECT * FROM `post` ORDER BY `id` DESC";
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
                <div style=" background-color:white; display: flex; max-width:500px;  margin:auto; border:solid thin #aaa; border-radius:10px; margin-bottom: 10px; margin-top:10px;">
                    <div style="flex:2; text-align: center; margin:12px;">
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
                        </div>

                    </div>
                </div>

            <?php endwhile ?>

        <?php endif; ?>
    </div>
    <?php include "footer.php"; ?>


</body>

</html>