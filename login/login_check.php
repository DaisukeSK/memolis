<?php
session_start();
require_once "../require/function.php";
$_SESSION["username"]=str2html($_POST["username"]);
$_SESSION["password"]=str2html($_POST["password"]);
$_SESSION["token"]=bin2hex(random_bytes(20));//used where??

/*
if(!empty($_SESSION["loggedIn"])){
    //echo $_SESSION["loggedIn"];
    echo "Already logged in."."<br>";
    echo '<a href="index.php">Back to the list.</a>';
    exit;
}
*/
// if(empty($_SESSION["username"]) || empty($_SESSION["password"])){
//     echo "Enter the username and password."."<br>";
//     echo '<a href="login.php">Back</a>';
//     exit;
// }

try{
$dbh=db_open();
$sql="select * from users where users.username=:username";
$stmt=$dbh->prepare($sql);
$stmt->bindParam(":username", $_SESSION["username"], pdo::PARAM_STR);

$stmt->execute();
$result=$stmt->fetch(pdo::FETCH_ASSOC);
if(!$result){
    
    // echo 'Failed to log in.(1)'.'<br>';
    // echo '<a href="login.php">Back</a>';

    echo '<script>alert("Username or password is incorrect.")</script>';
    echo '<script>location.href="../login/login.php"</script>';
    exit;
}
$_SESSION["userId"]=$result["id"];
echo $_SESSION["userId"];


$aa=password_verify($_SESSION["password"], $result["password"]);
if($aa){
    session_regenerate_id(true);
    $_SESSION["loggedIn"]=true;
    header("location:../index/index.php");
}else{
    // echo "Failed to log in.(2)"."<br>";
    // echo '<a href="login.php">Back</a>';

    echo '<script>alert("Username or password is incorrect.")</script>';
    
    echo '<script>location.href="../login/login.php"</script>';
}

}catch(PDOException $e){
    echo "ERROR : ".str2html($e->getMessage());
    exit;
}