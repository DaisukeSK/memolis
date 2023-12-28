<?php
session_start();
require_once "../require/function.php";
require_once "../require/login_status_check.php";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">

<link href="../css/common.css" rel="stylesheet">
<link href="../css/index.css" rel="stylesheet">
<script src="../index/init.js"></script>
</head>
<body>
<?php include "../include/header.php"; ?>
<h2></h2>

<!---------------- Form ---------------->
<form action="data_delete.php" method="get" onsubmit='return confirm("Are you sure that you want to delete data?")'>

<ul class="dataList">


<?php
try{
$dbh=db_open();

//var_dump($dbh);
// $sql='select * from words where user="'.$_SESSION["username"].'" order by date DESC, time DESC';
$sql='select * from words where user="'.$_SESSION["username"].'" order by second DESC';

$statement=$dbh->query($sql);
$i=0;

$_SESSION["data"]=[];
$_SESSION["dataCategory"]=[];
while($row=$statement->fetch()):
    
    $_SESSION["data"][$i]=[str2html($row["word"]),str2html($row["meaning"]),str2html($row["category"])];

    if(!in_array(str2html($row["category"]),$_SESSION["dataCategory"])){

        array_push($_SESSION["dataCategory"],str2html($row["category"]));
    }
$i++;
?>
    <li id="<?php echo $i ?>" class="dataLi">
    <div class="hiddenId" id="<?php echo $row["id"];?>" style="display:none"></div>
    <input type="checkbox" name="id[]" value="<?php echo (int) $row["id"];?>"/>
        <div class="liLeft">
            <div class="liLeftTop">
                <div class="liWord"><b><?php echo $row["word"];?></b></div>

                <a class="editImg" href="../edit/edit.php?id=<?php echo (int) $row["id"];?>">
                    
                    <?php include "../assets/svgConversion/pen.html"; ?>
                </a>&nbsp;
                <div class="editDelete">
                    <svg height="40" width="70">
                        <path d="M0 3 L 3 0 L67 0 L 70 3 L70 27 L67 30 L20 30 L10 40 L10 30 L3 30 L0 27 Z"></path>
                        <text x="20" y="20" fill="white">Edit</text>
                    </svg>

                </div>


                <a class="deleteImg" href="data_delete.php?id=<?php echo (int) $row["id"];?>" onclick='return confirm("Are you sure that you want to delete data?")'>
                    
                    <?php include "../assets/svgConversion/delete2.html"; ?>
                </a>&nbsp;
                <div class="editDelete">
                    <svg height="40" width="70">
                        <path d="M0 3 L 3 0 L67 0 L 70 3 L70 27 L67 30 L20 30 L10 40 L10 30 L3 30 L0 27 Z"></path>
                        <text x="12" y="20" fill="white">Delete</text>
                    </svg>

                </div>

            </div>
            
            
            <div class="liMeaning"><?php echo $row["meaning"];?></div>
        </div>

        <div class="liRight">
            <div class="liCategory"><?php echo $row["category"];?></div>

            <div class="liTime">
                <div class="date"><?php echo $row["date"];?></div>
                <div class="time"><?php echo $row["time"];?></div>
                
            </div>
        </div>
    </li>



<?php endwhile; ?>

<li class="topLi">
    <!-- <div class="topLiFlex"> -->
    <div class="anchor search">
        <img src="../assets/svg/search.svg"/>
        <input class="searchInput" type="text" placeholder="Enter Keyword."/>
    </div>
    <div class="anchor"><?php include "../assets/svgConversion/add2.html" ?>
        <a href='../include/input.php'>Add Data</a>
    </div>
    <!-- </div> -->
</li>
<li class="liCaption">
    <input type="checkbox" name="delete" value="all"/>
    <div class="divSubmit">
        <div class="divSubmitLeft">
            <input type="submit" name="submit" value=""/>
            <!-- <img src="delete.svg"/> -->
        </div>
        <div class="divSubmitRight">Delete selected data</div>
    </div>
    <div class="liLeft">
        <select name="alphabetically">
            <option value="default">Term / Definition</option>
            <option value="a-z">Sort A-Z</option>
            <option value="z-a">Sort Z-A</option>
    
        </select>



    </div>
    <div class="liRight">
        <div class="liCategory">
            
            <select name="category">
                <option value="Category">Category</option>

                <?php
                

                    foreach($_SESSION["dataCategory"] as $value){

                    
                ?>
                <option value="<?php echo $value;?>"><?php echo $value;?></option>
                
                
                <?php };?>
            
                    
            </select>
        
        </div>
        <div class="liTime">
            <select name="lastUpdated">
                <option value="default">Last updated</option>
                <option value="new">Sort New</option>
                <option value="old">Sort Old</option>
        
            </select>
        </div>
    </div>
    
</li>
<li class="noHit" style="display:none">No result...</li>

</ul>
</form>



<?php
}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}
?>

<script src="./index.js"></script>

<?php include "../include/footer.php"; ?>
</body>
</html>