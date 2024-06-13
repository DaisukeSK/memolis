<?php
    session_start();
    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]==true){
        //Need both conditions avobe, it shows error in login page otherwise.
        header("location:../index/index.php");
        exit;
    }
    $_SESSION["token_signUp"]=bin2hex(random_bytes(20));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
    <link href="../assets/images/memolis.ico" rel="shortcut icon">
    <link href="../assets/images/memolis.ico" rel="icon">
</head>

<body>
    <img class="logo" src="../assets/images/memolis4.svg"/>

    <section>

        <div class='form1'>
            <h2>Sign In</h2>
            <form class="container" action="login_check.php" method="post">
                <input type="text" name="userName" placeholder=" User name" required>
                <input type="password" name="password" placeholder=" Password" required>
                <input type="submit" value="Sign In">
            </form>
        </div>

        <div class='form2'>
            <div class="flex">
                <svg width="30" height="24">
                    <path d="m0 12 l12 -12 l3 3 l-9 9 l9 9 l-3 3 l-12 -12Z"/>
                    <path d="m13 12 l12 -12 l3 3 l-9 9 l9 9 l-3 3 l-12 -12Z"/>
                </svg>
                <h2>Sign Up</h2>
            </div>
            <form class="container" action="newAccount.php" method="post">
                <input type='hidden' value='<?php echo $_SESSION["token_signUp"];?>' name='token_signUp'>
                <input type="text" name="userName" placeholder=" User name" required>
                <input type="password" name="password1" placeholder=" Password" required>
                <input type="password" name="password2" placeholder=" Password (Confirm)" required>
                <input type="submit" value="Sign Up">
            </form>
        </div>

    </section>

    <p class="newAccountP">Don't have an account yet? <span class="createNewAccount">Sign Up.</span></p>

    <script src='../public/jquery-3.7.1.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <script src="./switchForm.js"></script>

    <?php include "../include/footer.php"; ?>

</body>
</html>

<?php
    if(isset($_SESSION["failed"]) && $_SESSION["failed"]==true){
        echo '<script src="new_account_failed.js"></script>';
        $_SESSION["failed"]=false;
    }
?>