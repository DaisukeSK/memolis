<?php

include_once "../ignore.php";

function str2entity(string $str):string{
    return htmlspecialchars($str,ENT_QUOTES,"utf-8");
}

function salt(string $str):string{
    return $str[strlen($str)-2].$str.$str[2];
}

function db_open(){

    $host=DBdata()[0];
    $dbname=DBdata()[1];
    $user=DBdata()[2];
    $password=DBdata()[3];
    
    $opt=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES=>false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS=>false,
    ];
    $dbh=new PDO("mysql:host=".$host.";dbname=".$dbname."", $user,$password,$opt);
    return $dbh;
}

function getTime(){
    date_default_timezone_set("America/Vancouver");
    $date=date("Y/m/d/H/i/s");
    return $date;
}

function categoryCheck($dbh,$userId){

    $array=[];
    $sql='select * from words where userId=:userId';
    $stmt=$dbh->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    while($row=$stmt->fetch()):
        array_push($array, $row['categoryId']);
    endwhile;

    $sql2='select * from categories where userId=:userId';
    $stmt2=$dbh->prepare($sql2);
    $stmt2->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt2->execute();

    while($row2=$stmt2->fetch()):
        if(!in_array($row2["id"], $array)){
            $sql3='delete from categories where id=:id';
            $stmt3=$dbh->prepare($sql3);
            $stmt3->bindParam(':id', $row2["id"], PDO::PARAM_INT);
            $stmt3->execute();
        }
    endwhile;
}