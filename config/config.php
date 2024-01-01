<?php
try {
    $servername = "localhost";
$username = "root";
$pass = "";
$dbname = "jobbard";

$conn = new PDO("mysql:servername=$servername;dbname=$dbname",$username,$pass);
} catch (PDOException $e) {
    echo $e -> getMessage();
}
    

if(!$conn){
 
    echo "error";

}



?>