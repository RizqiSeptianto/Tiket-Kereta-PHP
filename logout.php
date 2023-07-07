<?php

session_start();
include('functions.php');
unset($_SESSION["email"]);
session_destroy();
header('Location: login.php');
?>
