<?php
header("Access-Control-Allow-Origin: *");
$file="messages.txt";
$messages=file_get_contents($file);

if(isset($_GET["message"])){
    $message= $_GET["message"]."<br>" ;
    file_put_contents($file,$message,FILE_APPEND);
    echo "Added ".$message;
}else{
    echo $messages;
}
?>