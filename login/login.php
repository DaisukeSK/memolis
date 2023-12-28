<?php
session_start();
if(isset($_SESSION["loggedIn"])){
    header("location:../index/index.php");
    
    exit;//program stops
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">

    <link href="../assets/svg/memolis.ico" rel="shortcut icon">
    <link href="../assets/svg/memolis.ico" rel="icon">
    
</head>

<body>
<img class="logo" src="../assets/svg/memolis4.svg"/>


<div class="formFlex">
    
    <form class="form_1" action="login_check.php" method="post">
    <h2>Sign In</h2>
    <div class="container">
        <div class="grid_1">
            
            <label>User name</label>
            
            <input type="text" name="username" placeholder=" Enter your username." required>
            <label>Password</label>
            <input type="password" name="password" placeholder=" Enter your password." required>
            
        </div>
        
        <input class="submit_1" type="submit" value="Log In">
        
    </div>
</form>

<form class="form_2" action="newAccount.php" method="post">
    <div class="flex">
        <div class="xxx"><img src="../assets/svg/arrow_L.svg"/></div>
        <h2>Sign Up</h2>
    </div>
    <div class="container">
        <div class="grid_2">
            
            <label>User name</label>
            <input type="text" name="username" placeholder=" Enter your username." required>
            <label>Password</label>
            <input type="password" name="password" placeholder=" Enter your password." required>
            <label>Password (Confirm)</label>
            <input type="password" name="password2" placeholder=" Enter your password." required>
                
        </div>
        
        <!-- <div class="errorMsg"></div> -->
        <input class="submit_2" type="submit" value="Sign Up">
        
    </div>
</form>

</div>

<p class="newAccountP">Don't have an account yet? <span class="createNewAccount">Sign Up.</span></p>
    



<script src="./move_to_right.js"></script>
<script src="../index/init.js"></script>

<?php
include "../include/footer.php";
?>
</body>

</html>

<?php
if(isset($_SESSION["failed"]) && $_SESSION["failed"]==true){

    echo '<script src="new_account_failed.js"></script>';
    
    $_SESSION["failed"]=false;
}
?>