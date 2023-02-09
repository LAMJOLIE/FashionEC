<?php 

$db = new PDO($dsn, "se_c_root", "29_Man");

if($db){
    echo "Connection Successful"
}else{
    echo "Connection Failed";
}

mysqli_select_db($db)

?>