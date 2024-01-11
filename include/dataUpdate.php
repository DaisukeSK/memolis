<?php
session_start();

require_once "../require/login_status_check.php";
require_once "../require/function.php";


// date_default_timezone_set("America/Vancouver");
$date=getTime()[0];
$time=getTime()[1];
$second=getTime()[2];

echo $date."<br>";
echo $time."<br>";
echo $second."<br><br><br>";



if($_POST["id"]){
    $id=$_POST["id"];
};

$word=str2html($_POST["word"]);
$meaning=str2html($_POST["meaning"]);

// if(isset($_POST["category"])){
//     $category=str2html($_POST["category"]);
// }


// $select_add=str2html($_POST["select_add"]);



// if($newCategory!=="" && $category=="NewCategory"){
if(isset($_POST["newCategory"]) && $_POST["select_add"]=="add"){

    echo "newCategory is set"."<br>";
    $newCategory=str2html($_POST["newCategory"]);

    if($newCategory=="Category"){
        echo '<script>alert("You cannot use that category name.")</script>';
        if(isset($id)){
            echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
        }else{
            echo '<script>location.href="../include/input.php"</script>';
        }
        exit;
    }


    foreach($_SESSION["categories"] as $val){
        if($val==$newCategory){
            
            echo '<script>alert("That category already exists.")</script>';
            if(isset($id)){
                echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
            }else{
                echo '<script>location.href="../include/input.php"</script>';
            }
            
            exit;
        }
    }
    // $category=$newCategory;
}else if(isset($_POST["category"]) && isset($_POST["newCategory"])==false){
    echo "newCategory is NOT set"."<br>";
    $category=str2html($_POST["category"]);
}







////////////////////////////////////////////////////
////////////////////////////////////////////////////
////////////////////////////////////////////////////

//if($newCategory!==""){
// if($category){
    
//     $Category=$category;
// }else{
//     $Category=$newCategory;
// }

// if($Category==""){
//     $Category="-";
// }


//echo "Category:".$Category."<br>";
$aa=preg_match("/\A[[:^cntrl:]]{1,200}\z/u", $word);
if(!$aa){
    echo '<script>alert("The word is too long, you can enter up to 200 characters.")</script>';
        if(isset($id)){
            echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
        }else{
            echo '<script>location.href="../include/input.php"</script>';
        }
    exit;
}

$bb=preg_match("/\A[[:^cntrl:]]{1,200}\z/u", $meaning);
if(!$bb){
    echo '<script>alert("The meaning is too long, you can enter up to 200 characters.")</script>';
        if(isset($id)){
            echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
        }else{
            echo '<script>location.href="../include/input.php"</script>';
        }
    exit;
}


/////////////////////////////////////////////////////////
///////////////////// open db ///////////////////////////
/////////////////////////////////////////////////////////

try{
    $dbh=db_open();


    ///////////// Check if there's the same term already /////////////

    $sql='select id, word from words where userId=:userId';
    $stmt=$dbh->prepare($sql);

    $stmt->bindParam(':userId', $_SESSION["userId"], PDO::PARAM_INT);
    $stmt->execute();


    // if(isset($id)){
        // $sql='select id, word from words where user="'.$_SESSION["username"].'" && id='.$id.'';
        // $stmt2=$dbh->query($sql);
        // $rslt2=$stmt2->fetch();
        // echo $id."<br/>";
        // echo $rslt2[0]."<br/>";
        // echo $rslt2[1]."<br/>";
        
        // while($rslt=$stmt->fetch()):
            
        //     if($rslt[1]==$word && $rslt[0]!=$id){
        //         echo '<script>alert("That term already exists in the list.")</script>';
        //         echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
        //         exit;
                
        //     }
        // endwhile;

    // }else{
        while($rslt=$stmt->fetch()):
            
            if($rslt[1]==$word){
                if(isset($id) && $rslt["id"]!=$id){
                    echo '<script>alert("That term already exists in the list.")</script>';
                    echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
                    exit;
                }else if(!isset($id)){
                    echo '<script>alert("That term already exists in the list.")</script>';
                    echo '<script>location.href="input.php"</script>';
                    exit;
                }
            }
        endwhile;
    // }


    

    
    // echo "No problem";
    // exit;

    ///////////// Add to DB /////////////

    // $newCategoryId="";
    // echo "newCategoryId(1)".$newCategoryId."<br/>";
    if(isset($_POST["newCategory"]) && $_POST["select_add"]=="add"){

        $sql2='insert into categories (id, userId, user, category) values (null, :userId, :userName, :category)';
        $stmt2=$dbh->prepare($sql2);
        $stmt2->bindParam(':userId', $_SESSION["userId"], PDO::PARAM_INT);
        $stmt2->bindParam(':userName', $_SESSION["username"], PDO::PARAM_STR);
        $stmt2->bindParam(':category', $newCategory, PDO::PARAM_STR);

        $stmt2->execute();

        $newCategoryId=$dbh->lastInsertId();
    }

    if(isset($newCategoryId) && !isset($category)){
        $category=$newCategoryId;
    }


    echo "[word]:".$word."<br>";
    echo "[meaning]:".$meaning."<br>";
    echo "[select or add]:".$_POST["select_add"]."<br>";
    echo "[category]:".$category."<br>";
    echo "[newCategory]:".$newCategory."<br>";
    echo "[newCategoryId]:".$newCategoryId."<br><br>";

 
    
    if(isset($id)){

        $sql3="update words set word=:word, meaning=:meaning, categoryId=:category, date=:date, time=:time, second=:second where id=:id";
        $stmt3=$dbh->prepare($sql3);

        // $id=(int)$id;

        $stmt3->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt3->bindParam(":word", $word, PDO::PARAM_STR);
        $stmt3->bindParam(":meaning", $meaning, PDO::PARAM_STR);
        $stmt3->bindParam(":category", $category, PDO::PARAM_INT);
        $stmt3->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt3->bindParam(":time", $time, PDO::PARAM_STR);
        $stmt3->bindParam(":second", $second, PDO::PARAM_STR);
        $stmt3->execute();

        echo '<script>alert("Data updated.")</script>';

        categoryCheck($dbh, $_SESSION['userId']);


    }else{

        $sql4="insert into words (id, userId, user, word, meaning, categoryId, date, time, second) values (null, :userId, :user, :word, :meaning, :category, :date, :time, :second)";
        $stmt4=$dbh->prepare($sql4);
        //var_dump($stmt);
        
        $stmt4->bindParam(":userId", $_SESSION["userId"], PDO::PARAM_INT);
        $stmt4->bindParam(":user", $_SESSION["username"], PDO::PARAM_STR);
        $stmt4->bindParam(":word", $word, PDO::PARAM_STR);
        $stmt4->bindParam(":meaning", $meaning, PDO::PARAM_STR);
        $stmt4->bindParam(":category", $category, PDO::PARAM_INT);
        $stmt4->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt4->bindParam(":time", $time, PDO::PARAM_STR);
        $stmt4->bindParam(":second", $second, PDO::PARAM_STR);
        $stmt4->execute();

        echo '<script>alert("Data added.")</script>';
    }

    echo "newCategoryId(-)".$newCategoryId."<br/>";

    

    echo '<script>location.href="../index/index.php"</script>';
    
}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}
?>