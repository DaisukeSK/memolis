<?php
session_start();
$_SESSION=array();
session_destroy();

echo '
    <script>
        alert("See you.");
        location.href="./login.php";
    </script>
';