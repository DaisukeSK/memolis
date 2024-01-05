<?php
    session_start();
    require_once "../require/login_status_check.php";
    require_once "../require/function.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add data</title>
    <meta charset="utf-8">
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/input.css" rel="stylesheet">
    <link href="../assets/svg/memolis.ico" rel="shortcut icon">
    <link href="../assets/svg/memolis.ico" rel="icon">
</head>

<body>

    <?php include "../include/header.php"; ?>
    <!-- <div class="link">
        <a href="../index.php">Back to the list.</a>
    </div> -->
    <div class="container">

        <form method="post" action="../include/dataUpdate.php">

            <input type="hidden" name="id"/>
            <!-- <div class="grid"> -->

                <label><b>Term</b></label>
                <input type="text" name="word" placeholder=" Type a term." required>

                <label><b>Definition</b></label>
                <textarea name="meaning" rows="3" placeholder=" Type a definition." required></textarea>
                
                <div class="inputFlex">
                    
                    <div class="flexChild">
                        <input type="radio" name="select_add" value="select" checked>
                        <label><b>Select category</b></label>
                        <select name="category">
                            <?php foreach($_SESSION["dataCategory"] as $value){ ?>
                                <option value="<?php echo $value;?>"><?php echo $value;?></option>
                            <?php }; ?>
                        </select>
                    </div>

                    <div>OR</div>

                    <div class="flexChild">
                        <input type="radio" name="select_add" value="add"/>
                        <label><b>Add new category</b></label>
                        <input type="text" name="newCategory" required/>
                    </div>

                </div>

            <!-- </div> -->

            <input type="submit" value="Add Data">

        </form>

    </div>

    <script src="../include/switchInput.js"></script><!-- src should be like this so it is accessible from edit.php too -->
    
    <script src="../index/init.js"></script>
    <?php include "../include/footer.php"; ?>

</body>
</html>