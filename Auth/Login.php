<?php include('../php/config.php');
session_start();
if(isset($_SESSION["UserName"])){
    header("Location: ".$Url.'Home');
    exit();
}
    $Alert='';
    $ClassAlert='';
    $UserName="";
    $Password="";
    
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include('../php/PDO.php');
    $UserName=$_POST['UserName'];
    $Password=$_POST['Password'];
    $sql="SELECT * FROM TUsers WHERE (Email='$UserName' OR UserName='$UserName') and UPassword='$Password'";
    $Check=$conn->query($sql)->fetchAll();
    if (count($Check)==1&&$Check[0][5]==1){
        $Alert='Login Succeed';
        $ClassAlert='alert-success';
        $row=$Check[0];
        session_start();
        $_SESSION["id"]=$row[0];
        $_SESSION["FullName"]=$row[1];
        $_SESSION["UserName"]=$row[2];
        $_SESSION["Email"]=$row[3];
        $_SESSION['ProfileImageId']=$row[9];
        $sql="UPDATE TUsers Set LastLogin=(now()) where UserName='$UserName' ";
        $conn->exec($sql);

        header("Location: ".$Url."Home");
    }
    else{
        $Alert='Please make sure your data is correct';
        $ClassAlert='alert-danger';
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
    <style>
        .Style{
            margin-top:1rem;
        }
        .Style.btn{
            font-size:1.6rem;
        }

    </style>
</head>
<body>
    <div class="container">
        <?php include('../PagesTools/NavBar.php');?>
        <div class="container" style='margin-top:5rem'>
            <div class="alert <?php echo $ClassAlert;?>" role="alert">
                <?php echo $Alert;?>
            </div>
            <h1 style='text-align: center;font-size:7rem'>Login</h1>
            <form action="Login.php" method="post">
                <input class="form-control form-control-lg Style" name="UserName" type="text" placeholder="UserName Or Email" value='<?php echo $UserName;?>' required>
                <input class="form-control form-control-lg Style" pattern="^[A-z 0-9 \W+]{8,50}" title="Password Must be Have More Then 8 Caracter" name="Password" type="password" placeholder="Password" value='<?php echo $Password; ?>' required>
                <div class="d-grid gap-2">
                <button class="btn btn-info btn-lg Style" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>    
    <?php include('../PagesTools/Scripts.php');?>
</body>
</html>