<?php

include_once('./php/session.php');
include_once('./php/config.php');
include_once('./php/PDO.php');
$DisabledInputs='';
$Id=$_SESSION['id'];

if(empty($_GET['To'])){
    $DisabledInputs='disabled';
    $_GET['To']=0;
}
else{
    $To=$_GET['To'];
    $sql="SELECT * from TUsers WHERE id='$To'";
    $Result=$conn->query($sql)->fetchAll();
    if(count($Result)==0||$To==$_SESSION['id']){
        header("Location: ".$Url."Home");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ Home</title>
    <link rel="stylesheet" href="./css/Chat.css">
    <?php include_once('./PagesTools/Head.php');?>
</head>
<body>
    <div class="container" style='margin-bottom:6rem;'>
        <?php include_once('./PagesTools/NavBar.php');?>

        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="ChatBox border border-5" id='ChatBox'>

                    </div>
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col">   
                            <div class="ChatShowMsg border border-5" id='ChatShowMsg'>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="ChatTextBox" id='ChatTextBox'>
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-floating">
                                            <input maxlength="50" class="form-control" id="TextMsg" style="height: 4rem" <?php echo $DisabledInputs;?>>
                                            <label for="TextMsg" style="color:black">Msg:</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button id='btnSend' class="SendBtn btn btn-info btn-lg" <?php echo $DisabledInputs;?>>Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('./PagesTools/Scripts.php');?>
    <script>
        var elem = document.getElementById('ChatShowMsg');
        $(document).ready(
            function(){
                var i=0;
                if(<?php echo $_GET['To'];?>!=0){
                    $('#btnSend').click(
                        function(){
                            $.post('MsgsSend.php',{To:<?php echo $_GET['To'];?>,Msg:$('#TextMsg').val()})
                            $('#TextMsg').val('')
                        }
                    )
                }

                setInterval(function(){
                    $('#ChatBox').load('MsgsFromUsers.php')
                    if(<?php echo $_GET['To'];?>!=0){
                        $('#ChatShowMsg').load('Msgs.php?To=<?php echo $_GET['To'];?>')
                        if(i==1){                        
                            elem.scrollTop = elem.scrollHeight;
                            i++
                        }
                        i++
                        if(i==3){
                            i=2
                        }
                    }
                }, 1000);


            }
        )   
    </script>
</body>
</html>
<?php $conn = null;?>