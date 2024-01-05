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

    // if(
    //     $newCategory=="-Add New Category-" ||
    //     $newCategory=="-" ||
    //     $newCategory=="Category" ||
    //     $newCategory=="NewCategory"
    //     ){
    //     echo '<script>alert("You cannot use that category name.")</script>';
    //     if(isset($id)){
    //         echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
    //     }else{
    //         echo '<script>location.href="../include/input.php"</script>';
    //     }
    //     exit;
    // }


    foreach($_SESSION["dataCategory"] as $val){
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
    $category=$newCategory;
}else if(isset($_POST["category"]) && isset($_POST["newCategory"])==false){
    echo "newCategory is NOT set"."<br>";
    $category=str2html($_POST["category"]);
}



echo "[word]:".$word."<br>";
echo "[meaning]:".$meaning."<br>";
echo "[select or add]:".$_POST["select_add"]."<br>";
echo "[category]:".$category."<br><br>";



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

    $sql='select id, word from words where userId="'.$_SESSION["userId"].'"';
    $stmt=$dbh->query($sql);





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
                if(isset($id) && $rslt[0]!=$id){
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
    
    if(isset($id)){

        $sql="update words set word=:word, meaning=:meaning, category=:category, date=:date, time=:time, second=:second where words.id=:id";
        $stmt2=$dbh->prepare($sql);

        $id=(int)$id;

        $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt2->bindParam(":word", $word, PDO::PARAM_STR);
        $stmt2->bindParam(":meaning", $meaning, PDO::PARAM_STR);
        $stmt2->bindParam(":category", $category, PDO::PARAM_STR);
        $stmt2->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt2->bindParam(":time", $time, PDO::PARAM_STR);
        $stmt2->bindParam(":second", $second, PDO::PARAM_STR);
        $stmt2->execute();

        echo '<script>alert("Data updated.")</script>';

    }else{

        $sql="insert into words (id, userId, user, word, meaning, category, date, time, second) values (null, :userId, :user, :word, :meaning, :category, :date, :time, :second)";
        $stmt2=$dbh->prepare($sql);
        //var_dump($stmt);
        
        $stmt2->bindParam(":userId", $_SESSION["userId"], PDO::PARAM_INT);
        $stmt2->bindParam(":user", $_SESSION["username"], PDO::PARAM_STR);
        $stmt2->bindParam(":word", $word, PDO::PARAM_STR);
        $stmt2->bindParam(":meaning", $meaning, PDO::PARAM_STR);
        $stmt2->bindParam(":category", $category, PDO::PARAM_STR);
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