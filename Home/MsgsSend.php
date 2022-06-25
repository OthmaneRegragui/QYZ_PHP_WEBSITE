<?php
ini_set('display_errors','On');
ini_set('error_reporting',E_ALL);
include_once('./php/session.php');
include_once('./php/config.php');

if($_SERVER['REQUEST_METHOD']=="GET"){
  header("Location: ".$Url."Home");
}
if ($_SERVER['REQUEST_METHOD']=='POST'&& strlen($_POST['Msg'])!=0){
    include_once('./php/PDO.php');
    $Id=$_SESSION['id'];
    $To=$_POST['To'];
    $Msg=$_POST['Msg'];

    $sql="SELECT * from TUsers WHERE id='$To'";
    $Result=$conn->query($sql)->fetchAll();
    if(count($Result)==1){
        $sql="INSERT INTO TMassageChat(`UserFromId`,`UserToId`,`MText`) VALUES ('$Id','$To','$Msg');";
        $conn->exec($sql);
    }

}

?>
