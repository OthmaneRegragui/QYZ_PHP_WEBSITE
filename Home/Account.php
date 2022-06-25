<?php
include_once('./php/session.php');
include_once('./php/PDO.php');
$UserId=$_SESSION['id'];
$IdOfUser=$_GET['id'];
$DisabledInputs='';

if($UserId==$IdOfUser){
    $DisabledInputs='disabled';
    $_GET['To']=0;
}
if(empty($IdOfUser)){
    header("Location: ".$Url.'Home');
}
$sql="SELECT U.UserName,F.data from TUsers U inner join TFiles F ON U.ImageFileId =F.id WHERE U.id='$IdOfUser'";
$Check=$conn->query($sql)->fetchAll()[0];
$UserName=$Check[0];
$ImageProfile=base64_encode($Check[1]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ <?php echo $UserName?></title>
    <?php include_once('./PagesTools/Head.php');?>
</head>
<body>
    <div class="container">
        <?php include_once('./PagesTools/NavBar.php');?>
        <div class="logo-image" style='margin-bottom:1rem;height:auto;width:auto;margin-left:40%;'>
            <?php echo '<img class="img-fluid" style="width:15rem;" src="data:image/jpeg;base64,'.$ImageProfile.'"/><br>';?>
        </div>
        <div style='clear:both;margin-bottom:5rem;text-align:center;font-size:3rem;font-weight:bold;'>
            <p><?php echo $UserName?></p>
            <div class="d-grid gap-2">
                <button class="btn btn-info btn-lg Style" type="submit" onclick="window.location.href='Chat.php?To=<?php echo $IdOfUser?>'" <?php echo $DisabledInputs?>>Say Hi</button>
            </div>
        </div>
    </div>
    <?php include_once('./PagesTools/Scripts.php');?>
</body>
</html>
<?php $conn = null; ?>
