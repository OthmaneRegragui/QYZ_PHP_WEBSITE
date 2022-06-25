<?php
include_once('./php/config.php');
if($_SERVER['REQUEST_METHOD']=="GET"){
  header("Location: ".$Url."Home");
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    
    include('./php/session.php');
    $UserId=$_SESSION['id'];
    include('./php/PDO.php');
    $Target=$_POST['Target'];
    $SearchBy=$_POST['SearchBy'];
    if($SearchBy=='Name'){
        $sql="SELECT id,GName,GDescription FROM TGroups WHERE (AllowUsersToSendJoinRequest=1) and (GNAME LIKE '%$Target%') and ( id not in (select GroupId from TUsersOfGroups WHERE UserId = '$UserId'))";
    }
    else{
        $sql="SELECT id,GName,GDescription FROM TGroups WHERE (AllowUsersToSendJoinRequest=1) and  (id LIKE '%$Target%') and ( id not in (select GroupId from TUsersOfGroups WHERE UserId = '$UserId'))";
    }
    $Result=$conn->query($sql)->fetchAll();
    echo json_encode($Result);
}

?>
<?php $conn = null; ?>