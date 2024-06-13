<?php
    session_start();
    require_once "../require/function.php";
    require_once "../require/login_status_check.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
    <link href="../assets/images/memolis.ico" rel="shortcut icon">
    <link href="../assets/images/memolis.ico" rel="icon">
</head>

<body>
    <?php include "../include/header.php"; ?>

    <!---------------- Form ---------------->
    <form
        action="data_delete.php"
        method="get"
        onsubmit='return confirm("Are you sure that you want to delete data?")'
    ><!-- This form is for multiple data deletion -->

        <input type='hidden' name='token' value='<?php echo (string) $_SESSION['token']; ?>'>
    
        <ul class="dataList">
            
            <li class="topLi">
                <div class="search">
                    <img src="../assets/images/search.svg"/>
                    <input class="searchInput" type="text" placeholder="Enter Keyword."/>
                </div>
                <div class="add">
                    <?php include "../assets/svg/add.html" ?>
                    <a href='../include/input.php'>Add Data</a>
                </div>
            </li>

            <?php
                try{
                    $dbh=db_open();

                    $sql='select term, definition, category, date, words.id from words inner join categories on words.categoryId=categories.id where words.userId=:userId order by date DESC';
                    $stmt=$dbh->prepare($sql);
                    $stmt->bindParam(':userId', $_SESSION["userId"], PDO::PARAM_INT);
                    $stmt->execute();

                    $_SESSION["dataCount"]=$stmt->rowCount();
                    $_SESSION["categories"]=[];

                    while($row=$stmt->fetch()):

                        $dateStr=explode('/',$row['date']);
                        if(!in_array($row["category"],$_SESSION["categories"])){
                            array_push($_SESSION["categories"],$row["category"]);
                        }
            ?>

            <li class="dataLi">
                <div class="hiddenId" id="<?php echo $row["id"];?>"></div><!-- Necessary?? -->
                <input type="checkbox" name="id[]" value="<?php echo (int) $row["id"];?>"/>

                <div class="liLeft">
                    <div class="liLeftTop">
                        <div class="liTerm">
                            <b><?php echo $row["term"];?></b>
                        </div>

                        <a class="editDeleteAnchor" href="../edit/edit.php?id=<?php echo (int) $row["id"];?>">
                            <?php include "../assets/svg/pen.html"; ?>
                            <svg class="editDelete" height="40" width="70">
                                <path d="M0 3 L 3 0 L67 0 L 70 3 L70 27 L67 30 L20 30 L10 40 L10 30 L3 30 L0 27 Z"></path>
                                <text x="20" y="20" fill="white">Edit</text>
                            </svg>
                        </a>

                        <a
                            class="editDeleteAnchor"
                            href="data_delete.php?id=<?php echo (int) $row["id"];?>&token=<?php echo (string) $_SESSION['token'];?>"
                            onclick='return confirm("Are you sure that you want to delete data?")'
                        >
                            <?php include "../assets/svg/delete.html"; ?>
                            <svg class="editDelete" height="40" width="70">
                                <path d="M0 3 L 3 0 L67 0 L 70 3 L70 27 L67 30 L20 30 L10 40 L10 30 L3 30 L0 27 Z"></path>
                                <text x="12" y="20" fill="white">Delete</text>
                            </svg>
                        </a>

                    </div><!-- liLeftTop -->

                    <div class="liDefinition"><?php echo $row["definition"];?></div>
                </div><!-- liLeft -->

                <div class="liRight">
                    <div class="liCategory"><?php echo $row["category"];?></div>
                    <div class="liTime">

                        <div class="date">
                            <?php echo $dateStr[0].'/'.$dateStr[1].'/'.$dateStr[2];?>
                        </div>

                        <div class="time">
                            <?php
                                switch(true){
                                    case $dateStr[3]==0:
                                        echo '12:'.$dateStr[4].' am';
                                        break;
                                    case $dateStr[3]<12:
                                        echo $dateStr[3].':'.$dateStr[4].' am';
                                        break;
                                    case $dateStr[3]==12:
                                        echo '12:'.$dateStr[4].' pm';
                                        break;
                                    default:
                                        $t=$dateStr[3]-12;
                                        echo $t.':'.$dateStr[4].' pm';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endwhile; ?>

            <li class="liCaption">
                <input type="checkbox" name="delete" value="all"/>

                <div class="divSubmit">
                    <input type="submit" name="multipleDeletion" value=""/>
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
                    <select name="category">
                        <option value="Category">Category</option>

                        <?php foreach($_SESSION["categories"] as $value){ ?>
                            <option value="<?php echo $value;?>"><?php echo $value;?></option>
                        <?php };?>
                            
                    </select>

                    <select name="lastUpdated">
                        <option value="default">Last updated</option>
                        <option value="new">Sort New</option>
                        <option value="old">Sort Old</option>
                    </select>
                </div>
            </li>

            <li class="noHit">No result found...</li>

        </ul>
    </form>

    <?php
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage()."<br>";
            exit;
        }
    ?>

    <script src="./index.js"></script>
    <?php include "../include/footer.php"; ?>
</body>
</html>