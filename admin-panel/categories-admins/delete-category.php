<?php require "../layouts/header.php"; ?>    
<?php require "../../config/config.php"; ?>
<?php
if(!isset($_SESSION['email'])){
    header("location:".ADMINURL."/admins/login-admins.php");
   }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $delete = $conn->prepare("DELETE FROM `categories` WHERE id='$id'");
        $delete->execute();
        header("location:".ADMINURL."/categories-admins/show-categories.php");
    }else{
        header("location:http://localhost/joboard/404.php");
    }
?>
