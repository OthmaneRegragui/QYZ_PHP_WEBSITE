<?php include('../php/config.php');
session_start();
if(isset($_SESSION["UserName"])){
    header("Location: ".$Url.'Home');
    exit();
}
    $Alert='';
    $ClassAlert='';
    $FullName="";
    $UserName="";
    $Email="";
    $Password="";
    
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include('../php/PDO.php');
    $FullName=$_POST['FullName'];
    $UserName=$_POST['UserName'];
    $Email=$_POST['Email'];
    $Password=$_POST['Password'];
    $sql="SELECT * FROM TUsers WHERE (Email='$Email' OR UserName='$UserName')";
    $Check=$conn->query($sql)->fetchAll();
    if (count($Check)>0){
        $Alert='UserName Or Email Already Be Used';
        $ClassAlert='alert-danger';
    }
    else{
        $sql="INSERT INTO TUsers( `FullName`,`UserName`, `Email`, `UPassword`) VALUES ('$FullName','$UserName','$Email','$Password');";
        $conn->exec($sql);
        $Alert='Register Succeed';
        $ClassAlert='alert-success';
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
    <?php include('../PagesTools/Head.php');?>
</head>
<body>
    <div class="container">
        <?php include('../PagesTools/NavBar.php');?>
        <div class="container" style='margin-top:5rem'>
            <div class="alert <?php echo $ClassAlert;?>" role="alert">
                <?php echo $Alert;?>
            </div>
            <h1 style='text-align: center;font-size:7rem'>Register</h1>
            <form action="Register.php" method="post">
                <input class="form-control form-control-lg Style" pattern="^[A-z]{3,}$" title="Full Name Must be Have More Then 2 Caracter And Without Special Character" name="FullName" type="text" placeholder="FullName" value='<?php echo $FullName;?>' required>
                <input class="form-control form-control-lg Style" pattern="^[A-z 0-9]{1,}[A-z 0-9 .\-\_]{3,}$" title="User Name Must be Have More Then 3 Caracter And Without Special Character" name="UserName" type="text" placeholder="UserName" value='<?php echo $UserName;?>' required>
                <input class="form-control form-control-lg Style" name="Email" type="email" placeholder="Email" value='<?php echo $Email;?>' required>
                <input class="form-control form-control-lg Style" pattern="^[A-z 0-9 \W+]{8,50}" title="Password Must be Have More Then 8 Caracter" name="Password" type="password" placeholder="Password" value='<?php echo $Password; ?>' required>
                <div class="d-grid gap-2">
                <button class="btn btn-info btn-lg Style" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>    
    <?php include('../PagesTools/Scripts.php');?>
</body>
</html>