<?php
include_once('./php/session.php');
include_once('./php/PDO.php');
$UserId=$_SESSION['id'];
$GroupId=$_GET['id'];
if(empty($GroupId)){
    header("Location: ".$Url.'Home');
}

$sql="SELECT * FROM TGroups WHERE id='$GroupId'";
$Group=$conn->query($sql)->fetchAll();
if(count($Group)==0){
   header("Location: ".$Url.'Home'); 
}


if(count($Group)==1){
    $sql="SELECT * from TUsersOfGroups Where GroupId='$GroupId' AND UserId='$UserId' AND REQUEST='Accept'";
    $Check=$conn->query($sql)->fetchAll();
    if($Check[0][5]!='Accept'||count($Check)==0){
        header("Location: ".$Url.'Home');
    }
    $Group=$Group[0];
}

$sql="SELECT id,Title,PushDate from TPost WHERE GroupId='$GroupId';";
$Result=$conn->query($sql)->fetchAll();
$Result=array_reverse($Result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ <?php echo 'Group:'.$GroupId?></title>
    <?php include_once('./PagesTools/Head.php');?>
</head>
<body>
    <div class="container">
        <?php include_once('./PagesTools/NavBar.php');?>
        <p class="h1" style="margin-left:2%; margin-top:2rem; font-size:2rem;float:left"><?php echo 'GroupId:'.$GroupId?></p>
        <p class="h1" style="margin-left:15rem; margin-top:2rem; font-size:2rem;float:left;"><?php echo 'Name:'.$Group[1]?></p>
        <button onclick="window.location.href='NewPost.php?id=<?php echo $GroupId?>'" style="margin-left: 60%;" id='NewPost' type="button" class="btn btn-info">New Post</button>
        
        <?php 
        if($Check[0][3]=='Admin'||$Check[0][3]=='GiantAdmin'){
            echo '<button onclick="window.location.href=`ListOfRequests.php?id='.$GroupId.'`" style="" id="ListOfRequests" type="button" class="btn btn-info">List Of Requests</button>';
            echo '<button onclick="window.location.href=`BlackList.php?id='.$GroupId.'`" style="margin-left:5px" id="ListOfRequests" type="button" class="btn btn-info">Black List</button>';
             echo '<button onclick="window.location.href=`MembersOfGroup.php?id='.$GroupId.'`" style="margin-left:5px" id="ListOfRequests" type="button" class="btn btn-info">Members Of Group</button>';
        }
        ?>
        <div class="BoxOfGroups BoxOfPosts border border-5">
            <?php
            foreach($Result as $R){
                print_r('<a href="Posts.php?id='.$R[0].'"><div class="card w-100 p-3 GroupPosts" style="width:auto;height:10rem" ><div class="card-body"><div class="cardDate">'.$R[2].'</div><div class="cardText">'.$R[1].'</div></div></div></a>');
            }
            
            ?>

        </div>
    </div>
    <?php include_once('./PagesTools/Scripts.php');?>
</body>
</html>
<?php $conn = null; ?>