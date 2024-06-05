<?php
session_start();
require_once "../require/function.php";

$_SESSION["userName"]=str2entity($_POST["userName"]);
$_SESSION["password"]=str2entity($_POST["password"]);

try{
    $dbh=db_open();

    $sql="select * from users where userName=:userName";
    $stmt=$dbh->prepare($sql);
    $stmt->bindParam(":userName", $_SESSION["userName"], pdo::PARAM_STR);
    $stmt->execute();

    $result=$stmt->fetch(pdo::FETCH_ASSOC);

    if(!$result){
        echo '
        <script>
            alert("You entered incorrect information.")
            location.href="../login/login.php"
        </script>
        ';
        exit;
    }
    
    if(password_verify($_SESSION["password"], $result["password"])){
        session_regenerate_id(true);
        $_SESSION["loggedIn"]=true;
        $_SESSION["userId"]=$result["id"];
        $_SESSION["token"]=bin2hex(random_bytes(20));
        header("location:../index/index.php");
    }else{
        echo '
        <script>
            alert("You entered incorrect information.")
            location.href="../login/login.php"
        </script>
        ';
    }

}catch(PDOException $e){
    echo "ERROR : ".$e->getMessage();
    exit;
}