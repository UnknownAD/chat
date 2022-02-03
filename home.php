<?php
ini_set('display_errors',1);
$pdo = new pdo("pgsql:host=localhost;dbname=postgres","postgres","stanlee");
$cmd = "select username from users where cookies=:cookie";
$exec = $pdo->prepare($cmd);
$r=$exec->execute(array(':cookie'=>$_COOKIE['cred_']));
$r=$exec->fetchAll()[0];
if(isset($_POST["msg"])){
        $time=date("h:i:sa");
        $date=date("Y-M-d");
        $cmd= "insert into msg (username,msg,date,time)values(:username,:msg,:date,:time)";
        $exc = $pdo->prepare($cmd);
        $exc->execute(array(":username"=>$r['username'],":msg"=>$_POST['msg'],':date'=>$date,":time"=>$time));
}
?>

<html>
<script src="/jquery.js"></script>
<script>
function ref(data){

 document.getElementById("msg").innerHTML=data;
}
$(document).ready(function(){
        
        $(".send").click(function(){
                $.post("/chat/home.php",{"msg":document.getElementsByTagName("input")[0].value},function(data,status){console.log(data)});
	})
       $(".refresh").click(function(){


              $.get("http://localhost/chat/refresh.php",data=>ref(data));
    }) 
})
</script>
<div">
<div id="msg">
<span>
<?php
$getm = $pdo->prepare("select * from msg where true");
$r=$getm->execute();$rows=$getm->fetchAll(); foreach($rows as $row){
        
	echo "<h>".$row['username']." : ".$row['msg']."</h>"."<br>";
        $last = array($row['time'],$row['date']);
}
?>
</span></div>
<input>
<button class="send">send</button>
<button class="refresh">refresh</button>
</div>
<script>
setInterval(function(){

$.get("http://localhost/chat/refresh.php",data=>ref(data));
},2000);
</script>
</html>
