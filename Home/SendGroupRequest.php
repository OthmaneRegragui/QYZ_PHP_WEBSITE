<?php
include_once('./php/session.php');
$UserId=$_SESSION['id'];
include_once('./php/config.php');
if($_SERVER['REQUEST_METHOD']=="GET"){
  header("Location: ".$Url."Home");
}
if($_SERVER['REQUEST_METHOD']=='POST'&&$UserId!=$_POST['Target']){
    include_once('./php/PDO.php');
    $Target=$_POST['Target'];
    $sql="SELECT id FROM TGroups WHERE (id='$Target') and (AllowUsersToSendJoinRequest=1)";
    $Result=$conn->query($sql)->fetchAll();
    if(count($Result)!=0){
        $sql="INSERT INTO TUsersOfGroups(`GroupId`,`UserId`,`UserGradeInGroup`,`REQUEST`) VALUES ('$Target','$UserId','Member','Wait');";
        $conn->exec($sql);
        echo 'True';
    }
    else{
        echo 'False';
    }

    
}

?>

<?php $conn = null;?>