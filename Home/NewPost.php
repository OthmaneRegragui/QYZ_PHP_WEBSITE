<?php
include_once('./php/session.php');
include_once('./php/PDO.php');
$UserId=$_SESSION['id'];

if($_SERVER['REQUEST_METHOD']=='GET'){
    $GroupId=$_GET['id'];
}
else{
    $GroupId=$_POST['GroupId'];
}

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

if($_SERVER['REQUEST_METHOD']=='POST'){
    $Title=$_POST['Title'];
    $Content=$_POST['Content'];
    $sql="INSERT INTO TPost(`UserId`,`GroupId`,`Title`,`PText`) VALUES ('$UserId','$GroupId','$Title','$Content');";
    $conn->exec($sql);
    header("Location: ".$Url.'Home/Group.php?id='.$GroupId);

}

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
        <h1 style="text-align: center; margin-top:2rem">New Post for <?php echo 'Group:'.$GroupId?></h1>

        <form action="NewPost.php" method="post">
            <input class="form-control form-control-lg Style" minlength='3' maxlength="20" name="Title" type="text" placeholder="Title" >
            <textarea minlength='2' maxlength="500" style="margin: top 2rem;" name="Content" id="mytextarea"></textarea>
            <div class="d-grid gap-2" style="margin-bottom:4rem">
                <button class="btn btn-info btn-lg Style" type="submit" Name='GroupId' value='<?php echo $GroupId?>'>Push New Post</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


    <script>

      tinymce.init({

        selector: '#mytextarea',
        menubar:false,
        plugins: [],

        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +

          'alignleft aligncenter alignright alignjustify | ' +

          'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'

      });

    </script>

    <?php include_once('./PagesTools/Scripts.php');?>
</body>
</html>
<?php $conn = null; ?>