<?php

require_once "../require/function.php";
require_once "../require/login_status_check.php";
//$aa=$_POST["delete"];


$id=$_GET["id"];

//var_dump($id);
echo "type: ".gettype($id)."<br/><br/>";

//echo "1st elmnt:".$id[0]."<br/>";
//echo "length:".count($id)."<br/>";

$ids="";
if(gettype($id)=="array"){
    foreach($id as $key => $value){
    
        $key==0 ? $ids.="(".$value : $ids.=",".$value;
    
    };
    $ids.=")";
}
echo "ids: ".$ids."<br/>";

try{
    $dbh=db_open();
    // Get category before deleting data
    
    // Delete data
    if($ids==""){
        
        $sql2="delete from words where id= :id";
        $stmt2=$dbh->prepare($sql2);
        
        $stmt2->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt2->execute();
    }else{
        
        $sql="delete from words where id in ".$ids;
        //$sql="delete from words where id in :id";
        //$stmt=$dbh->prepare($sql);
        $dbh->query($sql);
    
        // $stmt->bindParam(":id", $ids, PDO::PARAM_STR);
        // $stmt->execute();
    }

    echo '
        <script>
            alert("Data deleted.");
            location.href="./index.php";
        </script>
    ';
    exit;

    
}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}




?>