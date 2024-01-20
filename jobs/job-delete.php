<?php
require "../config/config.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $delete = $conn-> prepare("DELETE FROM jobs WHERE id = '$id'");
    $delete->execute();
    header("location:../index.php");
}
?>