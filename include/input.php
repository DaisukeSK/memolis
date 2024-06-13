<?php
    require_once "../require/login_status_check.php";
    require_once "../require/function.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/input.css" rel="stylesheet">
    <link href="../assets/images/memolis.ico" rel="shortcut icon">
    <link href="../assets/images/memolis.ico" rel="icon">
</head>

<body>
    <?php include "../include/header.php"; ?>

    <form class="container" method="post" action="../include/dataUpdate.php">

        <input type="hidden" name="id"/>
        <input type='hidden' name='token' value='<?php echo $_SESSION['token']; ?>'/>

        <label><b>Term</b></label>
        <input type="text" name="term" placeholder=" Type a term." required/>

        <label><b>Definition</b></label>
        <textarea name="definition" rows="3" placeholder=" Type a definition." required></textarea>
        
        <div class="inputFlex">
            
            <div class="flexChild">
                <input type="radio" name="select_add" value="select" checked/>
                <label><b>Select category</b></label>
                <select name="category">
                    <?php
                        try{
                            $dbh=db_open();
                            $sql='select * from categories where userId=:userId';
                            $stmt=$dbh->prepare($sql);
                            $stmt->bindParam(":userId", $_SESSION["userId"], PDO::PARAM_INT);
                            $stmt->execute();

                            while($row=$stmt->fetch()):
                    ?>

                    <option value="<?php echo $row["id"];?>">
                        <?php echo $row["category"];?>
                    </option>

                    <?php
                            endwhile;

                        }catch(PDOException $e){
                            echo "Error: ".$e->getMessage()."<br>";
                            exit;
                        }
                    ?>
                </select>
            </div>

            <div>OR</div>

            <div class="flexChild">
                <input type="radio" name="select_add" value="add"/>
                <label><b>Add new category</b></label>
                <input type="text" name="newCategory" required/>
            </div>

        </div>

        <input type="submit" value="Add Data"/>

    </form>

    <script src='../public/jquery-3.7.1.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>

    <script src="../include/switchInput.js"></script><!-- src should be like this so it is accessible from edit.php too -->
    <?php include "../include/footer.php"; ?>

</body>
</html>