<?php
include('connect.php');
if (!isset($_SESSION["type"])) 
{
    header("location:login.php");
} 
include('header.php');
exit();
?>
