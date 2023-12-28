<?php
session_start();

require_once "../require/login_status_check.php";
require_once "../require/function.php";

date_default_timezone_set("America/Vancouver");
$date=date("Y/m/d");
$time=date("h:i a");
$second=date("Y/m/d/H/i/s");
// If change, change newAccount.php as well.

echo "[date]:".$date."<br>";
echo "[time]:".$time."<br>";
echo "[second]:".$second."<br>";

if($_POST["id"]){
    $id=$_POST["id"];
};

$word=str2html($_POST["word"]);
$meaning=str2html($_POST["meaning"]);

if(isset($_POST["category"])){
    $category=str2html($_POST["category"]);
}

if(isset($_POST["newCategory"])){
    $newCategory=str2html($_POST["newCategory"]);
}

$select_add=str2html($_POST["select_add"]);

echo "[word]:".$word."<br>";
echo "[meaning]:".$meaning."<br>";
echo "[select or add]:".$select_add."<br>";
echo "[category]:".$category."<br>";
echo "[newCategory]:".$newCategory."<br><br>";

if($newCategory){
    echo "newCategory is set"."<br>";
}else{
    echo "newCategory is NOT set"."<br><br>";
}

// if($newCategory!=="" && $category=="NewCategory"){
if($newCategory){

    if(
        $newCategory=="-Add New Category-" ||
        $newCategory=="-" ||
        $newCategory=="Category" ||
        $newCategory=="NewCategory"
        ){
        //echo "You can't use that category name.";
        echo '<script>alert("YOU cant use that category name.")</script>';
        if(isset($id)){
            echo '<script>location.href="edit.php?id='.$id.'"</script>';
        }else{
            echo '<script>location.href="../include/input.php"</script>';
        }
        exit;
    }


    foreach($_SESSION["dataCategory"] as $val){
        if($val==$newCategory){
            
            echo '<script>alert("That category already exists.")</script>';
            if(isset($id)){
                echo '<script>location.href="edit.php?id='.$id.'"</script>';
            }else{
                echo '<script>location.href="../include/input.php"</script>';
            }
            
            exit;
        }
    }
}

////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////

//if($newCategory!==""){
if($category){
    
    $Category=$category;
}else{
    $Category=$newCategory;
}

// if($Category==""){
//     $Category="-";
// }
echo "[Final Category]:".$Category."<br><br>";

//echo "Category:".$Category."<br>";
$aa=preg_match("/\A[[:^cntrl:]]{1,200}\z/u", $word);
if(!$aa){
    echo "Please enter the word correctly.";
    exit;
}

$bb=preg_match("/\A[[:^cntrl:]]{1,200}\z/u", $meaning);
if(!$bb){
    echo "Please enter the meaning correctly.";
    exit;
}


/////////////////////////////////////////////////////////
///////////////////// open db ///////////////////////////
/////////////////////////////////////////////////////////

try{
    $dbh=db_open();


    ///////////// Check if there's the same term already /////////////

    $sql='select id, word from words where user="'.$_SESSION["username"].'"';
    $stmt=$dbh->query($sql);

    if(isset($id)){
        $sql='select id, word from words where user="'.$_SESSION["username"].'" && id='.$id.'';
        $stmt2=$dbh->query($sql);
        $rslt2=$stmt2->fetch();
        // echo $id."<br/>";
        // echo $rslt2[0]."<br/>";
        // echo $rslt2[1]."<br/>";
        
        while($rslt=$stmt->fetch()):
            
            if($rslt[1]==$word){
                if($rslt[0]!=$id){

                    echo '<script>alert("That term already exists in the list.")</script>';
                    echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
                    exit;
                }
            }
        endwhile;

    }else{
        while($rslt=$stmt->fetch()):
            
            if($rslt[1]==$word){
                
                echo '<script>alert("That term already exists in the list.")</script>';
                echo '<script>location.href="input.php"</script>';
                exit;
            }
        endwhile;
    }
    
    // echo "No problem";
    // exit;

    ///////////// Add to DB /////////////
    
    if(isset($id)){

        $sql="update words set word=:word, meaning=:meaning, category=:category, date=:date, time=:time, second=:second where words.id=:id";
        $stmt2=$dbh->prepare($sql);

        $id=(int)$id;

        $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt2->bindParam(":word", $word, PDO::PARAM_STR);
        $stmt2->bindParam(":meaning", $meaning, PDO::PARAM_STR);
        $stmt2->bindParam(":category", $Category, PDO::PARAM_STR);
        $stmt2->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt2->bindParam(":time", $time, PDO::PARAM_STR);
        $stmt2->bindParam(":second", $second, PDO::PARAM_STR);
        $stmt2->execute();

        echo '<script>alert("Data updated.")</script>';

    }else{

        $sql="insert into words (id, user, word, meaning, category, date, time, second) values (null, :user, :word, :meaning, :category, :date, :time, :second)";
        $stmt2=$dbh->prepare($sql);
        //var_dump($stmt);
        
        $stmt2->bindParam(":user", $_SESSION["username"], PDO::PARAM_STR);
        $stmt2->bindParam(":word", $word, PDO::PARAM_STR);
        $stmt2->bindParam(":meaning", $meaning, PDO::PARAM_STR);
        $stmt2->bindParam(":category", $Category, PDO::PARAM_STR);
        $stmt2->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt2->bindParam(":time", $time, PDO::PARAM_STR);
        $stmt2->bindParam(":second", $second, PDO::PARAM_STR);
        $stmt2->execute();

        echo '<script>alert("Data added.")</script>';
    }
    echo '<script>location.href="../index/index.php"</script>';
    
}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}
?>