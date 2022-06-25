<?php include_once('./php/config.php');
session_start();
if(!isset($_SESSION["UserName"])){
    header("Location: ".$Url);
    exit();
}
?>
