<?php
include_once('./php/session.php');
include_once('./php/config.php');
include_once('./php/PDO.php');
$Id=$_SESSION['id'];
$To=$_GET['To'];

$sql="SELECT * from TUsers WHERE id='$To'";
$InformationTo=$conn->query($sql)->fetchAll();
if(count($InformationTo)==0||$To==$_SESSION['id']){
    header("Location: ".$Url."Home");
}

$UserNameTo=$InformationTo[0]['UserName'];



$sql="SELECT * from TMassageChat WHERE (UserFromId='$To' AND UserToId='$Id') OR (UserFromId='$Id' AND UserToId='$To') ";
$Result=$conn->query($sql)->fetchAll();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Chat.css">
</head>
<body>
    <?php
    foreach($Result as $V){
        if($V['UserFromId']==$Id){
            $X1='MSGIn';
        }
        else{
            $X1='MSGOut';
        }
        if($V['UserFromId']==$Id){
            $X2=$_SESSION["UserName"];
        }
        else{
            $X2=$UserNameTo;
        }
        print_r('<div class="MSGContainer '.$X1.'"><div class='.'"'.'Name">'.$X2.'</div><div class='.'"'.'MDate">'.$V["MDate"].'</div><div class="'.'MGSText">'.$V["MText"].'</div></div>');

    }
    
    
    ?>
</body>
</html>