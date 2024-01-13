<?php

function str2html(string $str):string{
    return htmlspecialchars($str,ENT_QUOTES,"utf-8");
}

function db_open(){
    $user="root";
    $password="";
    $opt=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES=>false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS=>false,
    ];
    $dbh=new PDO("mysql:host=localhost;dbname=sample_db",$user,$password,$opt);
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