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

    // $user="sql3673292";
    // $password="6IXqJTVStm";
    // $opt=[
    //     PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    //     PDO::ATTR_EMULATE_PREPARES=>false,
    //     PDO::MYSQL_ATTR_MULTI_STATEMENTS=>false,
    // ];
    // $dbh=new PDO("mysql:host=sql3.freesqldatabase.com;dbname=sql3673292",$user,$password,$opt);
    // return $dbh;

}

// Host: sql3.freesqldatabase.com
// Database name: sql3673292
// Database user: sql3673292
// Database password: 6IXqJTVStm
// Port number: 3306

function getTime(){

    date_default_timezone_set("America/Vancouver");
    $date=date("Y/m/d");
    $time=date("h:i a");
    $second=date("Y/m/d/H/i/s");

    return [$date,$time,$second];
}

function categoryCheck($dbh,$userId){

    $array=[];

    $sql='select * from words where userId=:userId';
    $stmt=$dbh->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    while($row=$stmt->fetch()):
        echo "id:".$row['categoryId'].'<br/>';
        array_push($array, $row['categoryId']);
    endwhile;

    var_dump($array);
    echo '<br/><br/>';

    $sql2='select * from categories where userId=:userId';
    $stmt2=$dbh->prepare($sql2);
    $stmt2->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt2->execute();


    while($row2=$stmt2->fetch()):
        echo "id:".$row2['id'].', category:'.$row2['category'].'<br/>';

        if(!in_array($row2["id"], $array)){

            echo '[[[ id:'.$row2["id"].' is not in the array.]]]'.'<br/>';

            $sql3='delete from categories where id=:id';
            $stmt3=$dbh->prepare($sql3);
            $stmt3->bindParam(':id', $row2["id"], PDO::PARAM_INT);
            $stmt3->execute();
        }


    endwhile;


}