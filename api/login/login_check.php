<?php
session_start();
// require_once "../require/function.php";

function db_open(){
    // $host='localhost';
    // $dbname='sample_db';
    // $user="root";
    // $password="";
    // $opt=[
    //     PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_EMULATE_PREPARES=>false,
    //     PDO::MYSQL_ATTR_MULTI_STATEMENTS=>false,
    // ];
    // $dbh=new PDO("mysql:host=".$host.";dbname=".$dbname."", $user,$password,$opt);
    // return $dbh;


    $host='sql3.freesqldatabase.com';
    $dbname='sql3673292';
    $user="sql3673292";
    $password="6IXqJTVStm";
    $opt=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES=>false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS=>false,
    ];
    $dbh=new PDO("mysql:host=".$host.";dbname=".$dbname."", $user,$password,$opt);
    return $dbh;
}

$_SESSION["userName"]=str2html($_POST["userName"]);
$_SESSION["password"]=str2html($_POST["password"]);
$_SESSION["token"]=bin2hex(random_bytes(20));//used where??

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

    $_SESSION["userId"]=$result["id"];

    $aa=password_verify($_SESSION["password"], $result["password"]);
    if($aa){
        session_regenerate_id(true);
        $_SESSION["loggedIn"]=true;
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
    echo "ERROR : ".str2html($e->getMessage());
    exit;
}