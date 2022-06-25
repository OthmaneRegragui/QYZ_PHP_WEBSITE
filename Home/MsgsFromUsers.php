<?php
include_once('./php/session.php');
include_once('./php/config.php');
include_once('./php/PDO.php');
$Id=$_SESSION['id'];
$ArrIds=[];
$sql="SELECT DISTINCT UserToId,UserFromId from TMassageChat WHERE (UserToId='$Id') OR (UserFromId='$Id')";
$Result=$conn->query($sql)->fetchAll();
$Result=array_reverse($Result);
foreach($Result as $v){
    if($v['UserToId']!=$Id){
        array_push($ArrIds,$v['UserToId']);
    }
    if($v['UserFromId']!=$Id){
        array_push($ArrIds,$v['UserFromId']);
    }
}
$ArrIds=array_unique($ArrIds);
$Data=[];
foreach ($ArrIds as $ID) {
    $sql="SELECT UserName from TUsers WHERE (id='$ID')";
    $Result=$conn->query($sql)->fetch();
    $sql="SELECT data from TFiles WHERE (UserIdFrom='$ID')";
    $ImageD=$conn->query($sql)->fetch()[0];
    array_push($Data,[$ID,$Result[0],$ImageD]);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Chat.css">
    <style>
        .UsersContainer{
            padding:0.5rem;
            background-size: cover;
            width: auto;
            background-color:rgba(250, 235, 215, 0.5);
            word-wrap: break-word;
        }
        .ImgUsers{
            display:inline-block;
            width: 4rem;
            border-radius: 90px;

        }
        .UserNameUsers{
            margin-left:3rem;
            display:inline-block;
            right: 20px;
            bottom: 20px
        }

    </style>
</head>
<body>
    

    <?php 
        foreach($Data as $d){
        print_r('<div class="UsersContainer"><a href=Chat.php?To='.$d[0].'><img class="ImgUsers" src="data:image/jpeg;base64,'.base64_encode($d[2]).'"/><div class="UserNameUsers">'.$d[1].'</div></a></div>');
        }
    
    ?>  
</body>
</html>