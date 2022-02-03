<?php
if(isset($_COOKIE['cred_'])){
header("location: /");

}
$dbs = new pdo("pgsql:host=localhost;dbname=postgres","postgres","stanlee");
$username=$_POST["username"];
$password=$_POST["password"];
$pseudo=$_POST["pseudo"];
print_r($_POST);
$cmd="INSERT INTO users (username,password,pseudo,cookies)values(:username,md5(:password),:pseudo,:cookies)";
$execution = $dbs->prepare($cmd);
$execution->execute(array(":username"=>$username,":password"=>$password,":pseudo"=>$pseudo,":cookies"=>uniqid($password)));
$execution->fetchAll();
$check = $dbs->prepare("select cookies from users where username='$username'");
$r=$check->execute();
$row=$check->fetchAll()[0];
if($row["cookies"]!==""){
$c= $row["cookies"];
header("Set-Cookie: cred_=$c ;Expires=Thu,28 Aug 2025 00:00:00 GMT; Path=/");

}
?>

