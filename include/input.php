<?php
session_start();
require_once "../require/login_status_check.php";
require_once "../require/function.php";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>add_php</title>
<meta charset="utf-8">
<link href="../css/common.css" rel="stylesheet">
<link href="../css/add_edit.css" rel="stylesheet">
<link href="../assets/svg/memolis.ico" rel="shortcut icon">
<link href="../assets/svg/memolis.ico" rel="icon">


</head>

<body>

<?php include "../include/header.php"; ?>
<!-- <div class="link">
    <a href="../index.php">Back to the list.</a>
</div> -->
<div class="container">
    <form method="post" action="dataUpdate.php">
    <input type="hidden" name="id"/>
        <div class="grid">
            <label><b>Term</b></label>
            <input type="text" name="word" placeholder=" Type a term." required>
            <label><b>Definition</b></label>
            <!-- <input type="text" name="meaning" required> -->
            <textarea name="meaning" rows="3" placeholder=" Type a definition." required></textarea>
            
            
            
            <div class="inputFlex">
                
                <div class="flexChild">
                    <input class="inlineElm" type="radio" name="select_add" value="select" checked>
                    <label class="inlineElm"><b>Select category</b></label>
                    <select name="category">
                        
        
                    <?php
                        foreach($_SESSION["dataCategory"] as $value){
                            // if($value!=="-"){
                    ?>
                    <option value="<?php echo $value;?>"><?php echo $value;?></option>
                    
                    <?php }; ?>
        
                    <!-- <option value="NewCategory">-Add New Category-</option> -->
        
                    </select>
                </div>

                <div>OR</div>

                <div class="flexChild">
                    
                    <input class="inlineElm" type="radio" name="select_add" value="add">
                    <label class="inlineElm"><b>Add new category</b></label>
                    <input type="text" name="newCategory" placeholder=" Type a new category." required>
                </div>

            </div>

            
            

        </div>
        <input type="submit" value="Add Data">
    </form>

</div>
<script src="../index/hideInput.js"></script>
<!-- <script src="../index/input.js"></script> -->
<script src="../index/init.js"></script>
<?php
include "../include/footer.php";
?>
</body>
</html>