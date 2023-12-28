<?php
session_start();
$_SESSION=array();
session_destroy();
// echo "Logged out."."<br>";
// echo '<a href="../login/login.php">Log In</a>';
echo '
    <script>
        alert("See you.");
        location.href="./login.php";
    </script>
';