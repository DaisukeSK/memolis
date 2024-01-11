<?php
session_start();
require_once "../require/function.php";
require_once "../require/login_status_check.php";

try{
    $dbh=db_open();
    //var_dump($dbh);
    $sql1='delete from users where id='.$_SESSION["userId"];
    $sql2='delete from words where userId='.$_SESSION["userId"];
    $sql3='delete from categories where userId='.$_SESSION["userId"];
    $dbh->query($sql1);
    $dbh->query($sql2);
    $dbh->query($sql3);
    
    session_destroy();
    // echo "Account deleted"."<br/>";
    // echo '<a href="./login/login.php">Home</a>';
    echo '
    <script>
        alert("Account deleted.");
        location.href="../login/login.php";
    </script>
';
}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}

?>