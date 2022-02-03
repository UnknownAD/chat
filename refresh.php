<?php
ini_set("display_errors",1);
$pdo = new pdo("pgsql:host=localhost;dbname=postgres","postgres","stanlee");
$cmd="select * from msg where true";
$e=$pdo->prepare($cmd);
$e->execute();
$rows=$e->fetchAll() ;
foreach($rows as $row){
        
        echo "<h>".$row['username']." : ".$row['msg']."</h>"."<br>";
        $last = array($row['time'],$row['date']);
}

?>
