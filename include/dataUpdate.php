<?php
session_start();
require_once "../require/login_status_check.php";
require_once "../require/function.php";

$date=getTime();

if($_POST["id"]){
    $id=$_POST["id"];
};

$term=str2html($_POST["term"]);
$definition=str2html($_POST["definition"]);

if(isset($_POST["newCategory"]) && $_POST["select_add"]=="add"){
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
}else if(isset($_POST["category"]) && isset($_POST["newCategory"])==false){
    $category=str2html($_POST["category"]);
}


$aa=preg_match("/\A[[:^cntrl:]]{1,200}\z/u", $term);
if(!$aa){
    echo '<script>alert("The term is too long, you can enter up to 200 characters.")</script>';
        if(isset($id)){
            echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
        }else{
            echo '<script>location.href="../include/input.php"</script>';
        }
    exit;
}

$bb=preg_match("/\A[[:^cntrl:]]{1,200}\z/u", $definition);
if(!$bb){
    echo '<script>alert("The definition is too long, you can enter up to 200 characters.")</script>';
        if(isset($id)){
            echo '<script>location.href="../edit/edit.php?id='.$id.'"</script>';
        }else{
            echo '<script>location.href="../include/input.php"</script>';
        }
    exit;
}

try{
    $dbh=db_open();

    ///////////// Check if there's the same term already /////////////
    $sql='select id, term from words where userId=:userId';
    $stmt=$dbh->prepare($sql);
    $stmt->bindParam(':userId', $_SESSION["userId"], PDO::PARAM_INT);
    $stmt->execute();

        while($rslt=$stmt->fetch()):
            if($rslt[1]==$term){
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
    
    ///////////// Add to DB /////////////

    if(isset($_POST["newCategory"]) && $_POST["select_add"]=="add"){
        $sql2='insert into categories (id, userId, category) values (null, :userId, :category)';
        $stmt2=$dbh->prepare($sql2);
        $stmt2->bindParam(':userId', $_SESSION["userId"], PDO::PARAM_INT);
        $stmt2->bindParam(':category', $newCategory, PDO::PARAM_STR);
        $stmt2->execute();
        $newCategoryId=$dbh->lastInsertId();
    }

    if(isset($newCategoryId) && !isset($category)){
        $category=$newCategoryId;
    }

    if(isset($id)){
        $sql3="update words set term=:term, definition=:definition, categoryId=:category, date=:date where id=:id";
        $stmt3=$dbh->prepare($sql3);
        $stmt3->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt3->bindParam(":term", $term, PDO::PARAM_STR);
        $stmt3->bindParam(":definition", $definition, PDO::PARAM_STR);
        $stmt3->bindParam(":category", $category, PDO::PARAM_INT);
        $stmt3->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt3->execute();
        echo '<script>alert("Data updated.")</script>';
        categoryCheck($dbh, $_SESSION['userId']);

    }else{
        $sql4="insert into words (id, userId, term, definition, categoryId, date) values (null, :userId, :term, :definition, :category, :date)";
        $stmt4=$dbh->prepare($sql4);
        $stmt4->bindParam(":userId", $_SESSION["userId"], PDO::PARAM_INT);
        $stmt4->bindParam(":term", $term, PDO::PARAM_STR);
        $stmt4->bindParam(":definition", $definition, PDO::PARAM_STR);
        $stmt4->bindParam(":category", $category, PDO::PARAM_INT);
        $stmt4->bindParam(":date", $date, PDO::PARAM_STR);
        $stmt4->execute();
        echo '<script>alert("Data added.")</script>';
    }

    echo '<script>location.href="../index/index.php"</script>';
    
}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}
?>