<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/protect.css">
   </head>
<body>
   
</body>
</html>

<?php
     if(!isset($_SESSION)){
        session_start();
     }
     
     if(!isset($_SESSION['id'])){
        die("<p style='color:white; font-size:20px; text-align:center;'>Acesso Negado.</p> <p><a class='enviar2' href=\"../Login.php\">Logar</a></p>");
     }

?>