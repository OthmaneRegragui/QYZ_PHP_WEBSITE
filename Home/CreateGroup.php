<?php
include_once('./php/config.php');
if($_SERVER['REQUEST_METHOD']=="GET"){
  header("Location: ".$Url."Home");
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    session_start();
    include_once('./php/PDO.php');
    $GroupName=$_POST['GroupName'];
    $Description=$_POST['Description'];
    if ($_POST['AllowUsersToSendJoinRequest']=='true'){
        $AllowUsersToSendJoinRequest=1;
    }
    else{
        $AllowUsersToSendJoinRequest=0;
    }
    if ($_POST['isPrivate']=='true'){
        $isPrivate=1;
    }
    else{
        $isPrivate=0;
    }
    $id=$_SESSION["id"];
   
    if(!empty($GroupName)){
        $sql="INSERT INTO TGroups(`GName`,`IdUserAdmin`,`GDescription`, `AllowUsersToSendJoinRequest`, `isPrivate`) VALUES ('$GroupName','$id','$Description','$AllowUsersToSendJoinRequest','$isPrivate');";
        $conn->exec($sql);
        $last_id = $conn->lastInsertId();
        $sql="INSERT INTO TUsersOfGroups(`GroupId`,`UserId`,`UserGradeInGroup`,`REQUEST`) VALUES ('$last_id','$id','GiantAdmin','Accept');";
        $conn->exec($sql);
        echo 'Succeed';
    }
    else{
        echo 'Error';
    }

}
?>
<?php $conn = null; ?>