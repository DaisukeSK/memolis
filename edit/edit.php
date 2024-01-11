<?php

    require_once "../require/login_status_check.php";
    include "../include/input.php";

    $id=$_GET["id"];
    //echo $id;

    $dbh=db_open();
    $sql="select * from words where id= :id";
    
    $stmt=$dbh->prepare($sql);

    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    if(!$result){
        echo "No data";
        exit;
    }
    //var_dump($result);

    // $id=$result["id"];
    $word=$result["word"];
    $meaning=$result["meaning"];
    $categoryId=$result["categoryId"];

    
    

?>

<script>
    console.log(document.querySelector('select[name="category"]'))
    //document.querySelector('select[name="category"]').value="AA"

    // document.querySelector('form').action="../include/dataUpdate.php"
    
    document.querySelector('option[value="<?php echo $categoryId ?>"]').selected=true
    
    document.querySelector('input[name="word"]').value="<?php echo $word;?>"
    console.log(document.querySelector('textarea').textContent)
    document.querySelector('textarea').textContent="<?php echo $meaning;?>"
    document.querySelector('input[name="id"]').value="<?php echo $id;?>"
    document.querySelector('input[type="submit"]').value="Update"
    document.querySelector('title').textContent="Edit data"
</script>
