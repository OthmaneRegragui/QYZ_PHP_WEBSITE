<?php include_once('./php/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QYZ</title>
    <?php include_once('./PagesTools/Head.php');?>
</head>
<body>
    <div class="container">
        <?php include_once('./PagesTools/NavBar.php');?>
        <p class="h1" id="TextHello" style="text-align: center; margin-top:10rem; font-size:10rem">Hello</p>
    </div>    
    <?php include_once('./PagesTools/Scripts.php');?>
    <script>
        var counter = 0;
        const text = document.getElementById("TextHello");
        setInterval(writeText, 2000);
        function writeText() {
            let Lang=['Bonjour','Hola','你好','Ciao','Hallo','Olá','مرحبا','Merhaba','Dzień dobry','Goedendag'];
            text.innerText = Lang[counter]
            counter++;
            if (counter==Lang.length-1){
                counter=0
            }
        }
    </script>
</body>
</html>