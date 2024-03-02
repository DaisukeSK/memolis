<?php
    session_start();
    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]==true){
        //Need both conditions avobe, it shows error in login page otherwise.
        header("location:../index/index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="/commonCss" rel="stylesheet">
    <link href="/loginCss" rel="stylesheet">
    <link href="../assets/svg/memolis.ico" rel="shortcut icon">
    <link href="../assets/svg/memolis.ico" rel="icon">
</head>

<body>
    <img class="logo" src="../assets/svg/memolis4.svg"/>

    <div class="formFlex">

        <form class="form_1" action="login_check" method="post">
            <h2>Sign In</h2>
            <div class="container">
                <label>User name</label>
                <input type="text" name="userName" placeholder=" Enter your user name." required>
                <label>Password</label>
                <input type="password" name="password" placeholder=" Enter your password." required>
                <input type="submit" value="Sign In">
            </div>
        </form>

        <form class="form_2" action="newAccount.php" method="post">
            <div class="flex">
                <svg width="30" height="24">
                    <path d="m0 12 l12 -12 l3 3 l-9 9 l9 9 l-3 3 l-12 -12Z"/>
                    <path d="m13 12 l12 -12 l3 3 l-9 9 l9 9 l-3 3 l-12 -12Z"/>
                </svg>
                <h2>Sign Up</h2>
            </div>
            <div class="container">
                <label>User name</label>
                <input type="text" name="userName" placeholder=" Enter your user name." required>
                <label>Password</label>
                <input type="password" name="password1" placeholder=" Enter your password." required>
                <label>Password (Confirm)</label>
                <input type="password" name="password2" placeholder=" Enter your password." required>
                <input type="submit" value="Sign Up">
            </div>
        </form>

    </div>

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