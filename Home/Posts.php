<?php
include_once('./php/session.php');
include_once('./php/PDO.php');
$UserId=$_SESSION['id'];
$PostId=$_GET['id'];
$Alert='';
$ClassAlert='';
if(empty($PostId)){
    header("Location: ".$Url.'Home');
}
$sql="SELECT GroupId,UserId,Title,PText,PushDate FROM TPost WHERE id='$PostId'";
$Post=$conn->query($sql)->fetchAll();
if(count($Post)==0){
   header("Location: ".$Url.'Home'); 
}
$Post=$Post[0];
$GroupId=$Post[0];
$UserIdOfPost=$Post[1];
$PushDate=$Post[4];

$sql="SELECT * from TUsersOfGroups Where GroupId='$GroupId' AND UserId='$UserId' AND REQUEST='Accept'";
$Check=$conn->query($sql)->fetchAll();
if($Check[0][5]!='Accept'||count($Check)==0){
    header("Location: ".$Url.'Home');
}


$sql="SELECT isPrivate FROM TGroups WHERE id='$GroupId'";
$isPrivate=$conn->query($sql)->fetch(); 
if($isPrivate[0]==1&&$Check[0][5]!='Accept'){
   header("Location: ".$Url.'Home'); 
}


if($_SERVER['REQUEST_METHOD']=='POST'&&!empty($_POST['CommentText'])){
    $TextComment=$_POST['CommentText'];
    $sql="INSERT INTO TComments(`UserId`,`GroupId`,`PostId`,`CText`) VALUES ('$UserId','$GroupId','$PostId','$TextComment');";
    $conn->exec($sql);
    $Alert='You Post A New Comment';
    $ClassAlert='alert-success';
}





$PostTitle=$Post[2];
$PostText=$Post[3];




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ</title>
    <?php include_once('./PagesTools/Head.php');?>
    <style>
        .BoxOfGroups{
            padding-left:1rem;
            margin-bottom:5rem;
        }
        .MSGOut {
            background-color: rgb(97, 123, 122);
        }

        .MSGContainer {
            color: white;
            padding: 10px;
            margin-top: 1rem;
            rotate: 90px;
            word-wrap: break-word;
        }

        .Name {
            float: left;
        }

        .MDate {
            position: relative;
            left: 80%;
        }

        .MGSText {
            margin-top: 30px;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include_once('./PagesTools/NavBar.php');?>

        <?php
        echo '<center><h1>'.$PostTitle.'</h1></center>'
        ?>
        <div class="BoxOfGroups BoxOfPosts border border-5">
            <?php
            echo $PostText;
            ?>
        </div>
        <?php
        $sql="SELECT U.UserName,F.data from TUsers U inner join TFiles F ON U.ImageFileId =F.id WHERE U.id='$UserIdOfPost'";
        $Check=$conn->query($sql)->fetchAll()[0];
        $ImageOfPostUser=base64_encode($Check[1]);
        
        ?>
        <div class="RNav">
        <a class="navbar-brand" href="<?php echo $Url.'Home/Account.php?id='.$UserIdOfPost;?>" style="float:left;">
            <p style='color:#354259'><?php echo $Check[0];?></p>
            <div class="logo-image">
                <?php echo '<img class="img-fluid" src="data:image/jpeg;base64,'.$ImageOfPostUser.'"/>';?>
            </div>
        </a><br>
        <p style='margin-left:10rem;color:#354259;font-size:2rem'>PushDate: <?php echo $PushDate;?></p>
        </div>
        <div class="alert <?php echo $ClassAlert;?>" role="alert">
            <?php echo $Alert;?>
        </div>
        <form method="post">
            <div class="mb-3">
                <label for="CommentText" style="color:#354259;font-size:2rem;" class="form-label">Comment:</label>
                <textarea class="form-control" name="CommentText" maxlength="500" id="CommentText" rows="3" require></textarea>
            </div>    
            <div class="d-grid gap-2" style="margin-bottom:4rem">
                <button class="btn btn-info btn-lg Style">New Comment</button>
            </div>        
        </form>
        <div style="height: 15rem;" class="BoxOfGroups BoxOfPosts border border-5">
        <?php
            $sql="SELECT UserId,CText,CDate from TComments WHERE PostId='$PostId' ";
            $Result=$conn->query($sql)->fetchAll();
            foreach($Result as $V){
                $sql="SELECT UserName from TUsers WHERE id='$V[0]' ";
                $UserName=$conn->query($sql)->fetch()[0];
                print_r('<div class="MSGContainer MSGOut"><a href="Account.php?id='.$V[0].'"><div class="Name">'.$UserName.'</div><a><div class="MDate">'.$V[2].'</div><div class="MGSText">'.$V[1].'</div></div>');

            }
        ?>
        </div>

    </div>
    <?php include_once('./PagesTools/Scripts.php');?>
</body>
</html>
<?php $conn = null; ?>