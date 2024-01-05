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
    echo '<script>alert("Passwords do not match.")</script>';
    echo '<script>location.href="login.php"</script>';
    
    
    exit;
}

if(strlen($password1)<6){
    // echo "Use 6 characters at least for a password."."<br>";
    // echo '<a href="../login/login.php">Back</a>';

    $_SESSION["failed"]=true;
    echo '<script>alert("Password requires 6 characters at least.")</script>';
    echo '<script>location.href="login.php"</script>';
    exit;
}

if($password1==$username){
    // echo "User name and password cannot be the same.".'<br>';
    // echo '<a href="../login/login.php">Back</a>';

    $_SESSION["failed"]=true;
    echo '<script>alert("Use different user name and password.")</script>';
    echo '<script>location.href="login.php"</script>';
    exit;    
}

try{
    
    $dbh=db_open();
    
    
    $sql='select * from users';
    $statement=$dbh->query($sql);
    
    while($row=$statement->fetch()):
        if($row[1]==$username){
            // echo "That user name is already used.".'<br>';
            // echo '<a href="../login/login.php">Back</a>';
    
            $_SESSION["failed"]=true;
    
            echo '<script>alert("That user name is already used.")</script>';
            echo '<script>location.href="login.php"</script>';
            exit;
        }
        //echo $row[1]."<br>";
    endwhile;


    $sql2="insert into users (id, username, password) values (null, :user, :password)";
    $stmt=$dbh->prepare($sql2);
    //var_dump($stmt);

    $stmt->bindParam(":user", $username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    $stmt->execute();


    $sql4="select id from users where username=:username";
    $stmt4=$dbh->prepare($sql4);
    $stmt4->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt4->execute();

    $userId=$stmt4->fetch(pdo::FETCH_ASSOC)["id"];

    // var_dump($result4);
    // echo "<br/>";
    // $_SESSION["userId"]=$result4;

    echo "userId: ".$userId."<br/>";


    $category1="noun";
    $category2="adverb";
    $category3="idiom";

    $data1='(null, "'.$userId.'", "'.$username.'", "breakthrough", "Sudden, dramatic and important discovery or development", "'.$category1.'", "'.$date.'", "'.$time.'", "'.$second.'")';
    $data2='(null, "'.$userId.'", "'.$username.'", "eventually", "In the end, especially after a long delay, dispute or series of problems.", "'.$category2.'", "'.$date.'", "'.$time.'", "'.$second.'")';
    $data3='(null, "'.$userId.'", "'.$username.'", "Break a leg", "A typical English idiom used in the context of theatre or other performing arts to wish a performer good luck.", "'.$category3.'", "'.$date.'", "'.$time.'", "'.$second.'")';
    $sql3="insert into words (id, userId, user, word, meaning, category, date, time, second) values ".$data1.",".$data2.",".$data3."";
    $stmt3=$dbh->query($sql3);
    //var_dump($stmt);

    // $data4='(null, "'.$username.'", "'.$category1.'")';
    // $data5='(null, "'.$username.'", "'.$category2.'")';
    // $data6='(null, "'.$username.'", "'.$category3.'")';


    // echo "Information confirmed."."<br>";
    // echo "<a href='../login/login.php'>Please log in from here.</a>";

    echo '<script>alert("New account confirmed.")</script>';
    echo '<script>location.href="login.php"</script>';

}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}
?>