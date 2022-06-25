<?php
include_once('./php/session.php');
include_once('./php/PDO.php');


$UserId=$_SESSION['id'];
if($_SERVER['REQUEST_METHOD']=='POST'){
    $GroupId=$_POST['GId'];
}
else{
    $GroupId=$_GET['id'];
}
if(empty($GroupId)){
    header("Location: ".$Url.'Home');
}
$sql="SELECT UserGradeInGroup from TUsersOfGroups Where UserId='$UserId' and GroupId='$GroupId'";
$UserGradeOfGroup=$conn->query($sql)->fetch()[0];
if($UserGradeOfGroup=='Member'){
    header("Location: ".$Url.'Home');
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['OP']=='Cancel'){
        $UserId=$_POST['UId'];
        $sql="DELETE FROM  TUsersOfGroups WHERE GroupId='$GroupId' and UserId='$UserId'";
        $conn->exec($sql);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ</title>
    <style>
        .btn{
            margin-bottom:1rem;
            width:100%;
        }
        .card-title{
            text-align: center;
            color:#354259;
        }
        .center{
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
    </style>
    <?php include_once('./PagesTools/Head.php');?>
</head>
<body>
    <div class="container">
        <?php include_once('./PagesTools/NavBar.php');?>
        <h1>Balck List</h1>
        <div class="" id="Alert" role="alert"></div>
        <div class="BoxOfGroups BoxOfPosts border border-5">
        <?php
        $sql="SELECT UserId,DateOfIn from TUsersOfGroups WHERE (GroupId='$GroupId') and REQUEST='Ban';";
        $Result=$conn->query($sql)->fetchAll();
        $Result=array_reverse($Result);
        
        foreach($Result as $R){
            $UserNameOFid=$conn->query("SELECT UserName From TUsers WHERE id='$R[0]'")->fetch()[0];
            $sql="SELECT data from TFiles WHERE (id=(SELECT ImageFileId FROM TUsers WHERE id='$R[0]'))";
            $ImageFileId=base64_encode($conn->query($sql)->fetch()[0]);
            print_r('<div id="'.$UserNameOFid   .'" class="card" style="margin-left:3rem;width:18rem;height:20rem;float:left;"><img class="center" style="width: 5rem;" src="data:image/jpeg;base64,'.$ImageFileId.'" class="card-img-top"><div class="card-body"><a href="Account.php?id='.$R[0].'"><h5 class="card-title">'.$UserNameOFid.'</h5></a><button onclick="Cancel('.$GroupId.','.$R[0].',`'.$UserNameOFid.'`)" class="btn btn-warning">Cancel</button><p style="color:black;text-align:center;">'.$R[1].'</p></div></div>');
        } 
        ?>
    </div>
    <?php include_once('./PagesTools/Scripts.php');?>
    <script>
        function Cancel(GroupId,UserId,UserName){
            $('#Alert').attr('class','alert alert-warning')
            $('#Alert').text(`${UserName} Cancel From Group`)
            $.post('BlackList.php',{GId:GroupId,UId:UserId,OP:'Cancel'})
            $(`#${UserName}`).remove()
        }
        function Ban(GroupId,UserId,UserName){
            $('#Alert').attr('class','alert alert-danger')
            $('#Alert').text(`${UserName} Ban From Group`)
            $.post('BlackList.php',{GId:GroupId,UId:UserId,OP:'Ban'})
            $(`#${UserName}`).remove()
        }
    </script>
</body>
</html>
<?php $conn = null; ?>