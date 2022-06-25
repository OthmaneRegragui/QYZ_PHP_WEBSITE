<?php 
include_once('./php/session.php');
include_once('./php/config.php');
include_once('./php/PDO.php');



$Id=$_SESSION["id"];
$FullName=$_SESSION["FullName"];
$UserName=$_SESSION["UserName"];
$Email=$_SESSION["Email"];
$Password="";
$RePassword='';


$FullNameErrorMsg='';
$FullNameErrorMsgColor='';

$UserNameErrorMsg='';
$UserNameErrorMsgColor='';

$EmailErrorMsg='';
$EmailErrorMsgColor='';

$RePasswordErrorMsg='';
$RePasswordErrorMsgColor='';

if(isset($_POST['SendImage'])){
    $ImageProfile=$_FILES['ImageProfile'];
    $Name=$ImageProfile['name'];
    $type=$ImageProfile['type'];
    $Data=file_get_contents($_FILES['ImageProfile']['tmp_name']);
    $sql="SELECT ImageFileId FROM TUsers WHERE (id='$Id')";
    $Check=$conn->query($sql)->fetch()[0];
if ($Check==1){
    $stmt = $conn->prepare("INSERT INTO TFiles (`Name`, `Mime`, `data`, `UserIdFrom`)
    VALUES (:Name, :Mime, :data, :UserIdFrom)");
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Mime', $type);
    $stmt->bindParam(':data', $Data);
    $stmt->bindParam(':UserIdFrom', $Id);
    $stmt->execute();
    $LID=$conn->lastInsertId();
    $sql="UPDATE TUsers SET ImageFileId=$LID WHERE (id='$Id');";
    $conn->exec($sql);
}
else{   
    $sql = "UPDATE TFiles SET data = :data WHERE id = :id;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $Check);
    $stmt->bindParam(':data', $Data, PDO::PARAM_LOB);
    $stmt->execute();
}
}   






if($_SERVER['REQUEST_METHOD']=='POST' && !isset($_POST['SendImage'])){
    $FullName=$_POST["FullName"];
    $UserName=$_POST["UserName"];
    $Email=$_POST["Email"];
    $Password=$_POST["Password"];
    $RePassword=$_POST["RePassword"];
    if($Password==$RePassword){
        if($FullName!=$_SESSION["FullName"]){
            try {
                $sql="Update TUsers set FullName='$FullName' WHERE id='$Id'";
                $conn->exec($sql);
                $_SESSION["FullName"]=$FullName;
                $FullNameErrorMsg='FullName Saved';
                $FullNameErrorMsgColor='Green';
            }
            catch(Exception $e) {
                $FullNameErrorMsg='Somthing Wrong!';
                $FullNameErrorMsgColor='Red';
            }

        }

        if($UserName!=$_SESSION["UserName"]){
            $sql="SELECT * FROM TUsers WHERE (UserName='$UserName')";
            $Check=$conn->query($sql)->fetchAll();
            if(count($Check)==0){
                try {
                    $sql="Update TUsers set UserName='$UserName' WHERE id='$Id'";
                    $conn->exec($sql);
                    $_SESSION["UserName"]=$UserName;
                    $UserNameErrorMsg='UserName Saved';
                    $UserNameErrorMsgColor='Green';
                }
                catch(Exception $e) {
                    $UserNameErrorMsg='UserName Are Ready Be Used!';
                    $UserNameErrorMsgColor='Red';
                }
            }
            else {
                $UserNameErrorMsg='UserName Are Ready Be Used!';
                $UserNameErrorMsgColor='Red';                
            }
        }
        if($Email!=$_SESSION["Email"]){
            $sql="SELECT * FROM TUsers WHERE (Email='$Email')";
            $Check=$conn->query($sql)->fetchAll();
            if(count($Check)==0){
                try {
                    $sql="Update TUsers set Email='$Email' WHERE id='$Id'";
                    $conn->exec($sql);
                    $_SESSION["Email"]=$Email;
                    $EmailErrorMsgColor='Email Saved';
                    $EmailErrorMsgColorColor='Green';
                }
                catch(Exception $e) {
                    $EmailErrorMsgColor='Email Are Ready Be Used!';
                    $EmailErrorMsgColorColor='Red';
                }
            }
            else{
                $EmailErrorMsgColor='Email Are Ready Be Used!';
                $EmailErrorMsgColorColor='Red';                
            }
        }
    }
    else{
        $RePasswordErrorMsg='RePassword Not Equal Password';
        $RePasswordErrorMsgColor='red';
    }


}

$sql="SELECT ImageFileId FROM TUsers WHERE (id='$Id')";
$ImageFileId=$conn->query($sql)->fetch()[0];
print_r($ImageFileId);
$sql="SELECT data FROM TFiles WHERE (id='$ImageFileId')";
$ImageProfile=base64_encode($conn->query($sql)->fetch()[0]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ Home</title>
    <?php include_once('./PagesTools/Head.php');?>
</head>
<body>
    <div class="container" style='margin-bottom:6rem;'>
        <?php include_once('./PagesTools/NavBar.php');?>
        <div class="logo-image" style="margin-bottom:1rem;height:auto;width:auto;margin-left:40%;">
        <?php echo '<img class="img-fluid" style="width:15rem;" src="data:image/jpeg;base64,'.$ImageProfile.'"/><br>';?>
        </div>
        <div class="d-grid gap-2" style='clear:both;margin-bottom:5rem;text-align:center;'>
            <form action="Profile.php" method="post" enctype="multipart/form-data">
                <input type='file' class="btn btn-info btn-lg Style" name='ImageProfile' id='ImageProfile' accept="image/*"><br>
                <input type="submit" class="btn btn-info btn-lg Style" name='SendImage' value='Change Profile Image'>
            </form>
        </div>
        <form action="Profile.php" method="post">
            <input class="form-control form-control-lg Style" name="Id" type="text" placeholder="Id" disabled value='<?php echo $Id;?>' >
            <input class="form-control form-control-lg Style" pattern="^[A-z]{3,}$" title="Full Name Must be Have More Then 2 Caracter And Without Special Character" name="FullName" type="text" placeholder="FullName" value='<?php echo $FullName;?>' >
            <p style="color:<?php echo $FullNameErrorMsgColor?>; font-size:1rem;"><?php echo $FullNameErrorMsg?></p>
            <input class="form-control form-control-lg Style" pattern="^[A-z 0-9]{1,}[A-z 0-9 .\-\_]{3,}$" title="User Name Must be Have More Then 3 Caracter And Without Special Character" name="UserName" type="text" placeholder="UserName" value='<?php echo $UserName;?>' >
            <p style="color:<?php echo $UserNameErrorMsgColor?>; font-size:1rem;"><?php echo $UserNameErrorMsg?></p>
            <input class="form-control form-control-lg Style" name="Email" type="email" placeholder="Email" value='<?php echo $Email;?>' >
            <p style="color:<?php echo $EmailErrorMsgColor?>; font-size:1rem;"><?php echo $EmailErrorMsg?></p>
            <input class="form-control form-control-lg Style" pattern="^[A-z 0-9 \W+]{8,50}" title="Password Must be Have More Then 8 Caracter" name="Password" type="password" placeholder="Password" value='<?php echo $Password; ?>' required>
            <p style="color:<?php echo $RePasswordErrorMsgColor?>; font-size:1rem;"><?php echo $RePasswordErrorMsg?></p>
            <input class="form-control form-control-lg Style" pattern="^[A-z 0-9 \W+]{8,50}" title="Password Must be Have More Then 8 Caracter" name="RePassword" type="password" placeholder="RePassword" value='<?php echo $RePassword; ?>' required>
            <div class="d-grid gap-2">
                <button class="btn btn-info btn-lg Style" type="submit">Save</button>
            </div>
        </form>
    </div>
    <?php include_once('./PagesTools/Scripts.php');?>
    <script>
        var uploadField = document.getElementById("ImageProfile");

        uploadField.onchange = function() {
            if(this.files[0].size > 2097152){
            alert("File is too big!");
            this.value = "";
            };
        };

    </script>
</body>
</html>
<?php $conn = null; ?>