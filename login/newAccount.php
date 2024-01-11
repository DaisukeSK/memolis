<?php
session_start();
require_once "../require/function.php";

//var_dump($_POST);

$username=str2html($_POST["username"]);
$password1=str2html($_POST["password1"]);
$password2=str2html($_POST["password2"]);
$password=password_hash($password1, PASSWORD_DEFAULT);

// date_default_timezone_set("America/Vancouver");

$date=getTime()[0];
$time=getTime()[1];
$second=getTime()[2];

echo $date."<br>";
echo $time."<br>";
echo $second."<br>";

// exit;
// if(empty($username)){
//     echo "Please enter a username"."<br>";
//     echo '<a href="../login/login.php">Back</a>';
//     exit;
// }

// if(empty($password1)||empty($password2)){
//     echo "Please enter a password"."<br>";
//     echo '<a href="../login/login.php">Back</a>';
//     exit;
// }

if(!($password1===$password2)){
    // echo "Passwords don't match."."<br>";
    // echo '<a href="../login/login.php">Back</a>';
    $_SESSION["failed"]=true;
    echo '
        <script>
            alert("Passwords do not match.")
            location.href="login.php"
        </script>
    ';
    exit;
}

if(strlen($password1)<6){
    // echo "Use 6 characters at least for a password."."<br>";
    // echo '<a href="../login/login.php">Back</a>';

    $_SESSION["failed"]=true;
    echo '
    <script>
        alert("Password requires 6 characters at least.")
        location.href="login.php"
    </script>
    ';
    exit;
}

if($password1==$username){
    // echo "User name and password cannot be the same.".'<br>';
    // echo '<a href="../login/login.php">Back</a>';

    $_SESSION["failed"]=true;
    echo '
    <script>
        alert("Use different user name and password.")
        location.href="login.php"
    </script>';
    exit;    
}

try{
    
    $dbh=db_open();
    
    
    $sql='select * from users';
    $stmt=$dbh->query($sql);
    
    while($row=$stmt->fetch()):
        if($row[1]==$username){
            // echo "That user name is already used.".'<br>';
            // echo '<a href="../login/login.php">Back</a>';
    
            $_SESSION["failed"]=true;
    
            echo '
            <script>
                alert("That user name is already taken.")
                location.href="login.php"
            </script>
            ';
            exit;
        }
        //echo $row[1]."<br>";
    endwhile;


    $sql2="insert into users (id, username, password) values (null, :user, :password)";
    $stmt2=$dbh->prepare($sql2);


    $stmt2->bindParam(":user", $username, PDO::PARAM_STR);
    $stmt2->bindParam(":password", $password, PDO::PARAM_STR);
    $stmt2->execute();


    // $stmt7=$dbh->query("select row_count()");
    // $aaa=$stmt7->fetch(pdo::FETCH_ASSOC);

    // var_dump($lastInsertId);
    // exit;


    // $sql4="select id from users where username=:username";
    // $stmt4=$dbh->prepare($sql4);
    // $stmt4->bindParam(":username", $username, PDO::PARAM_STR);
    // $stmt4->execute();

    // $userId=$stmt4->fetch(pdo::FETCH_ASSOC)["id"];


    $userId = $dbh->lastInsertId();


    // var_dump($result4);
    // echo "<br/>";
    // $_SESSION["userId"]=$result4;

    // echo "userId: ".$userId."<br/>";


    $category1="noun";
    $category2="adverb";
    $category3="idiom";

    $sql3='insert into categories (id, userId, user, category) values (null,'.$userId.',"'.$username.'","'.$category1.'")';
    $sql4='insert into categories (id, userId, user, category) values (null,'.$userId.',"'.$username.'","'.$category2.'")';
    $sql5='insert into categories (id, userId, user, category) values (null,'.$userId.',"'.$username.'","'.$category3.'")';
    
    $dbh->query($sql3);
    $categoryId1 = $dbh->lastInsertId();

    $dbh->query($sql4);
    $categoryId2 = $dbh->lastInsertId();

    $dbh->query($sql5);
    $categoryId3 = $dbh->lastInsertId();

    echo "userId:".$userId."<br/>";
    echo "categoryId1:".$categoryId1."<br/>";
    echo "categoryId2:".$categoryId2."<br/>";
    echo "categoryId3:".$categoryId3."<br/><br/>";

    echo "sql3:".$sql3."<br/>";
    echo "sql4:".$sql4."<br/>";
    echo "sql5:".$sql5."<br/>";


    $data1='(null, '.$userId.', "'.$username.'", "breakthrough", "Sudden, dramatic and important discovery or development", '.$categoryId1.', "'.$date.'", "'.$time.'", "'.$second.'")';
    $data2='(null, '.$userId.', "'.$username.'", "eventually", "In the end, especially after a long delay, dispute or series of problems.", '.$categoryId2.', "'.$date.'", "'.$time.'", "'.$second.'")';
    $data3='(null, '.$userId.', "'.$username.'", "Break a leg", "A typical English idiom used in the context of theatre or other performing arts to wish a performer good luck.", '.$categoryId3.', "'.$date.'", "'.$time.'", "'.$second.'")';
    $sql6="insert into words (id, userId, user, word, meaning, categoryId, date, time, second) values ".$data1.",".$data2.",".$data3."";
    $dbh->query($sql6);
    //var_dump($stmt);

    echo "sql6:".$sql6."<br/>";

    // $data4='(null, "'.$username.'", "'.$category1.'")';
    // $data5='(null, "'.$username.'", "'.$category2.'")';
    // $data6='(null, "'.$username.'", "'.$category3.'")';


    // echo "Information confirmed."."<br>";
    // echo "<a href='../login/login.php'>Please log in from here.</a>";

    echo '
    <script>
        alert("New account confirmed.")
        location.href="login.php"
    </script>
    ';

}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}
?>