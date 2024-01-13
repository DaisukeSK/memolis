<?php
require_once "../require/function.php";
require_once "../require/login_status_check.php";

$id=$_GET["id"];

$ids="";
if(gettype($id)=="array"){
    foreach($id as $key => $value){
        $key==0 ? $ids.="(".$value : $ids.=",".$value;
    };
    $ids.=")";
}else{
    $ids.="(".$id.")";
}

try{
    $dbh=db_open();
    $sql="delete from words where id in ".$ids;
    $dbh->query($sql);
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