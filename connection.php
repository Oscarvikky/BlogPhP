<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "blog_php");
if ($con) {
    echo "data base connect sucessfuly";
}
