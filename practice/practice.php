<?php
session_start();
require_once "../require/login_status_check.php";
require_once "../require/function.php";

$categories=$_POST["categories"];
$qNum=$_POST["num"];
$mode=$_POST["mode"];

$quizData=[];

$str="";
foreach($categories as $key=>$value){
    $key==0 ?
    $str.=$value :
    $str.=",".$value;
}

try{
    $dbh=db_open();
    $sql='select * from words where userId="'.$_SESSION["userId"].'" and categoryId in ('.$str.')';
    $statement=$dbh->query($sql);
    $count=$statement->rowCount();

    while($term=$statement->fetch()):
        array_push($quizData, $term);
    endwhile;

}catch(PDOException $e){
    echo "Error: ".$e->getMessage()."<br>";
    exit;
}

shuffle($quizData);

for($i=0; $i<$count; $i++){
    if($mode==1){
    $words[$i]=$quizData[$i]["term"];
    $meanings0[$i]=$quizData[$i]["definition"];
    $meanings1[$i][0]=$quizData[$i]["definition"];
    }else{
    $words[$i]=$quizData[$i]["definition"];
    $meanings0[$i]=$quizData[$i]["term"];
    $meanings1[$i][0]=$quizData[$i]["term"];
    }
    $rand=array_rand($quizData,4);
    for($j=0; $j<=3; $j++){
        if($mode==1){
        $meanings1[$i][$j+1]=$quizData[$rand[$j]]["definition"];
        }else{
        $meanings1[$i][$j+1]=$quizData[$rand[$j]]["term"];
        }
    }
    for($k=1; $k<=3; $k++){
        if($meanings1[$i][0]==$meanings1[$i][$k]){
            $temp=$meanings1[$i][$k];
            $meanings1[$i][$k]=$meanings1[$i][4];
            $meanings1[$i][4]=$temp;
        }
    }
    array_splice($meanings1[$i], 4, 1);
    shuffle($meanings1[$i]);
}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Practice</title>
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/practice.css" rel="stylesheet">
    <link href="../assets/images/memolis.ico" rel="shortcut icon">
    <link href="../assets/images/memolis.ico" rel="icon">
</head>

<body>

    <?php include "../include/header.php"; ?>

    <div class="quizContainer">

        <section class="result">
            <a href='./practice_pre.php'>Try again?</a>
        </section>

        <div class="bar">
            <div class="pageNum"></div>
        </div>
    <?php

for($i=0; $i<=$qNum-1; $i+=1){
    echo '
        <section class="quiz_area" id="echo'.$i.'">
            <div class="move2next">
            Click to continue...
            </div>
    ';
    if($mode==1){
    echo '
        <p>What does <b>'.$words[$i].'</b> mean?</p>
    ';
    }else{
    echo '
        <p>Which term means <b>'.$words[$i].'</b>?</p>
    ';
    }
    echo '<div class="options">';

    for($j=0; $j<=3; $j+=1){
        if($meanings0[$i]==$meanings1[$i][$j]){
            echo '
                <div class="answer option">
                    <img class="check invisible" src="../assets/images/check.svg"/>
                    <span>'.$meanings1[$i][$j].'</span>
                    <div class="optionFlex">
                    </div>
                </div>
            ';
        }else{
            echo '
                <div class="option">
                    <img class="cross invisible" src="../assets/images/x.svg"/>
                    <span>'.$meanings1[$i][$j].'</span>
                    
                </div>
            ';
        }
    }
    echo '</div></section>';
}
?>
</div>

<script src='../public/jquery-3.7.1.min.js'></script>
<script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
<script>
    
    let mode=<?php echo $mode;?>;
    let length=<?php echo $qNum;?>;
    let qArray=[];
    let rightAnswers=[];

    <?php foreach($words as $value){ ?>
        qArray.push(<?php echo '"'.$value.'"'; ?>)
    <?php } ?>

    <?php foreach($meanings0 as $value){ ?>
        rightAnswers.push(<?php echo '"'.$value.'"'; ?>)
    <?php } ?>

</script>

<script src="practice.js"></script>
<?php include "../include/footer.php"; ?>
</body>
</html>