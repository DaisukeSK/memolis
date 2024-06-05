<?php
session_start();
require_once "../require/function.php";

$token_signUp=$_POST["token_signUp"];
$userName=str2entity($_POST["userName"]);
$password1=str2entity($_POST["password1"]);
$password2=str2entity($_POST["password2"]);

$date=getTime();

function signUpFailed($message){
    $_SESSION["failed"]=true;
    echo '
        <script>
            alert("'.$message.'")
            location.href="login.php"
        </script>
    ';
    exit;
}

$password1!==$password2 && signUpFailed('Passwords do not match.');
strlen($password1)<6 && signUpFailed('Password requires 6 characters at least.');
$password1==$userName && signUpFailed('Use different user name and password.');
$token_signUp!==$_SESSION['token_signUp'] && signUpFailed('Invalid access.');

if($token_signUp===$_SESSION['token_signUp']){
    
    $password=password_hash(salt($password1), PASSWORD_DEFAULT);

    try{
        $dbh=db_open();
        $sql='select * from users';
        $stmt=$dbh->query($sql);
        
        while($row=$stmt->fetch()):
            if($row[1]==$userName){
                $_SESSION["failed"]=true;
                echo '
                <script>
                    alert("That user name is already taken.")
                    location.href="login.php"
                </script>
                ';
                exit;
            }
        endwhile;
    
        $sql2="insert into users (id, userName, password) values (null, :user, :password)";
        $stmt2=$dbh->prepare($sql2);
        $stmt2->bindParam(":user", $userName, PDO::PARAM_STR);
        $stmt2->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt2->execute();
    
        $userId = $dbh->lastInsertId();
    
        $category1="noun";
        $category2="adverb";
        $category3="idiom";
    
        $sql3='insert into categories (id, userId, category) values (null,'.$userId.',"'.$category1.'")';
        $sql4='insert into categories (id, userId, category) values (null,'.$userId.',"'.$category2.'")';
        $sql5='insert into categories (id, userId, category) values (null,'.$userId.',"'.$category3.'")';
        
        $dbh->query($sql3);
        $categoryId1 = $dbh->lastInsertId();
    
        $dbh->query($sql4);
        $categoryId2 = $dbh->lastInsertId();
    
        $dbh->query($sql5);
        $categoryId3 = $dbh->lastInsertId();
    
        $data1='(null, '.$userId.', "breakthrough", "Sudden, dramatic and important discovery or development", '.$categoryId1.', "'.$date.'")';
        $data2='(null, '.$userId.', "eventually", "In the end, especially after a long delay, dispute or series of problems.", '.$categoryId2.', "'.$date.'")';
        $data3='(null, '.$userId.', "Break a leg", "A typical English idiom used in the context of theatre or other performing arts to wish a performer good luck.", '.$categoryId3.', "'.$date.'")';
        $sql6="insert into words (id, userId, term, definition, categoryId, date) values ".$data1.",".$data2.",".$data3."";
        $dbh->query($sql6);
    
        echo '
        <script>
            alert("New account confirmed.")
            location.href="login.php"
        </script>
        ';
    
    }catch(PDOException $e){
        echo "Error: ".$e->getMessage()."<br>";
        exit;
    }
}

?>