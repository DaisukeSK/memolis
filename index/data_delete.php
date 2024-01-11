<?php

require_once "../require/function.php";
require_once "../require/login_status_check.php";
//$aa=$_POST["delete"];


$id=$_GET["id"];

var_dump($id);
echo "<br/><br/>";
echo "type: ".gettype($id)."<br/><br/>";

//echo "1st elmnt:".$id[0]."<br/>";
//echo "length:".count($id)."<br/>";





$ids="";
if(gettype($id)=="array"){
    foreach($id as $key => $value){
    
        $key==0 ? $ids.="(".$value : $ids.=",".$value;
    
    };
    $ids.=")";
}else{
    $ids.="(".$id.")";
}
echo "ids: ".$ids."<br/>";

try{
    $dbh=db_open();
    // Get category before deleting data
    
    // Delete data
    
        

    ///////////// Why doesn't it work? /////////////
        // $sql="delete from words where id in :ids";
        // $stmt=$dbh->prepare($sql);
        // $stmt->bindParam(":ids", $ids, PDO::PARAM_STR);
        // $stmt->execute();

        $sql="delete from words where id in ".$ids;
        $dbh->query($sql);

        
        


    
        // $stmt->bindParam(":id", $ids, PDO::PARAM_STR);
        // $stmt->execute();

        categoryCheck($dbh, $_SESSION['userId']);


    

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