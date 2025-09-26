<?php
require "functions.php";

session_destroy();
session_regenerate_id();
session_unset();

header("Location: login.php");
die;
