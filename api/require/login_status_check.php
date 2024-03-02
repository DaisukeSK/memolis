<?php
if(!isset($_SESSION)){
    session_start();
}

if(empty($_SESSION["loggedIn"])){
    echo "Invalid access.";
    exit;
}else{
    echo "<!--Logged in-->";
}