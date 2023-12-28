<?php
session_start();
require_once "../require/login_status_check.php";
require_once "../require/function.php";

$categories=$_POST["categories"];
$qNum=$_POST["num"];
$mode=$_POST["mode"];
//var_dump($qNum);
$_SESSION["words"]=[];

$str="";
foreach($categories as $key=>$value){
    $key==0 ? $str.='"'.$value.'"' : $str.=",".'"'.$value.'"';
}
//echo "str: ".$str."<br/>";
try{
    $dbh=db_open();
    //var_dump($dbh);
    $sql='select * from words where user="'.$_SESSION["username"].'" && category in ('.$str.')';
    
    $statement=$dbh->query($sql);
    $count=$statement->rowCount();
    //echo "number:".$number."<br/>";

    // if($number<4){
    //     echo '
    //     <script type="text/javascript">
    //         alert("You need to have 4 data at least.");
    //         location.href="practice_pre.php";
    //     </script>
    //     ';
    //     exit;
    // }
    


    // for($i=0; $i<$count; $i++){
    //     $_SESSION["words"][$i]=$statement->fetch();
    // }
    while($word=$statement->fetch()):
        array_push($_SESSION["words"], $word);
    endwhile;

    


    }catch(PDOException $e){
        echo "Error: ".str2html($e->getMessage())."<br>";
        exit;
    }
   
//var_dump($_SESSION["words"]);
//$count=count($_SESSION["words"]);//number of array objects
//echo "array elements=".$count.'<br>';


shuffle($_SESSION["words"]);
/*
for($i=$count-1; $i>=0; $i--){//same flow as shuffle() above
    $rand=mt_rand(0,$count-1);
    $temp=$_SESSION["words"][$i];
    $_SESSION["words"][$i]=$_SESSION["words"][$rand];
    $_SESSION["words"][$rand]=$temp;
}

for($i=0; $i<=$count-1; $i++){//just echo
    for($j=0; $j<=3; $j++){
    echo $_SESSION["words"][$i][$j];
    }echo '<br>';
}
*/

//echo "id=".$id;
for($i=0; $i<$count; $i++){
    if($mode==1){
    $words[$i]=str2html($_SESSION["words"][$i]["word"]);
    $meanings0[$i]=str2html($_SESSION["words"][$i]["meaning"]);
    $meanings1[$i][0]=str2html($_SESSION["words"][$i]["meaning"]);
    }else{
    $words[$i]=str2html($_SESSION["words"][$i]["meaning"]);
    $meanings0[$i]=str2html($_SESSION["words"][$i]["word"]);
    $meanings1[$i][0]=str2html($_SESSION["words"][$i]["word"]);
    }
    $rand=array_rand($_SESSION["words"],4);
    for($j=0; $j<=3; $j++){
        if($mode==1){
        $meanings1[$i][$j+1]=str2html($_SESSION["words"][$rand[$j]]["meaning"]);
        }else{
        $meanings1[$i][$j+1]=str2html($_SESSION["words"][$rand[$j]]["word"]);
        }
    }

    for($k=1; $k<=3; $k++){
        if($meanings1[$i][0]==$meanings1[$i][$k]){
            $temp=$meanings1[$i][$k];
            $meanings1[$i][$k]=$meanings1[$i][4];
            $meanings1[$i][4]=$temp;
        }
    }/**/
    array_splice($meanings1[$i], 4, 1);
    shuffle($meanings1[$i]);
}
// foreach($words as $key=> $value){
//     echo "word: ".$value."<br/>";
// }
// echo "<br/>";

// foreach($meanings0 as $key=> $value){
//     echo "meaning0: ".$value."<br/>";
// }
// echo "<br/>";

// foreach($meanings1 as $key=> $value){
//     foreach($value as $key=> $value2){
//         echo "meaning1: ".$value2."<br/>";
//     }
//     echo "<br/>";
// }
// echo "<br/>";
// $meanings0 : Array containing correct answers.
// $meanings1 : Array containing arrays that have 4 options including the correct answer.
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Practice</title>
<link href="https://fonts.googleapis.com/css?family=M+PLUS+1p:400,500" rel="stylesheet">

<script src="jquery-3.7.1.min.js"></script>
<script src="practice.js"></script>
<link href="../css/common.css" rel="stylesheet">
<link href="../css/practice.css" rel="stylesheet">
<link href="../assets/svg/memolis.ico" rel="shortcut icon">
<link href="../assets/svg/memolis.ico" rel="icon">

</head>
<body>
<?php include "../include/header.php"; ?>
<!-- <header class="link" style="display:none">
    <a href=../index.php>Home</a>
</header> -->
<!-- <main> -->
<main>
    

    <div class="barFrame">
        <div style="position:relative" class="bar">
            <div class="pageNum" style="position:absolute; right:0; bottom:3px;"></div>
        </div>
        
    </div>

    <!-- <div class="start">Start</div> -->

    <!-- <div class="hidden" id="next">
        <div>Click to continue...</div>
    </div> -->

    <!-- <div class="hidden" id="wrong">
        <div class="correct_or_wrong">Wrong</div>
        <div class="next">Next</div>
    </div> -->
   
    
    <section id="result" class="hidden"><div class="results"></div></section>

    

<?php

$add=1;
// for($i=0; $i<$count; $i+=1){
//for($i=$qNum; $i>=0; $i-=1){
for($i=$qNum-1; $i>=0; $i-=1){
    echo '
        <section class="hidden quiz_area" id="echo'.$i.'">
        <div class="hidden move2next"><div>Click to continue...</div></div>
        <div class="flex">
        
    ';
    if($mode==1){
    echo '
        
        <p class="question">What does <b class="mode1">'.str2html($words[$i]).'</b> mean?</p>
    ';
    }else{
    echo '
        
        <p class="question">Which term means <b class="mode2">'.str2html($words[$i]).'</b>?</p>
    ';
    }
    echo '<div id="page">('.$i+$add.'/'.$qNum.')</div></div>';
    echo '<div class="options">';
    for($j=0; $j<=3; $j+=1){
        if($meanings0[$i]==$meanings1[$i][$j]){
            
            // echo '
            //     <div id="answer" class="correctA option">
            //     <span class="check hidden"><img src="./check.svg"/></span>&nbsp;
            //     <span class="optionWord">'.$meanings1[$i][$j].'</span>
            //     </div>
            // ';
            echo '
                
                    <div id="answer" class="correctA option">
                        <div class="optionFlex">
                            <img class="check invisible" src="../assets/svg/check.svg"/>
                            <span class="optionWord">'.str2html($meanings1[$i][$j]).'</span>
                        </div>
                    </div>
                ';
        }else{
            echo '
                
                    <div class="option">
                        <div class="optionFlex">
                            <img class="cross invisible" src="../assets/svg/x.svg"/>
                            <span class="optionWord">'.str2html($meanings1[$i][$j]).'</span>
                        </div>
                    </div>
                ';
        }
    }
    echo '</div></section>';
}

?>

    <!--
    <div class="imagebox"></div>
    <div class="toolbar">
        <div class="nav"></div>
    </div>-->

</main><!--container1 -->
<!-- </main> -->

<!---->
<script src="../index/init.js"></script>
<script>
"use strict";
let length=<?php echo $qNum;?>;
</script>
<?php
include "../include/footer.php";
?>
</body>
</html>