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
    $str.='"'.$value.'"' :
    $str.=",".'"'.$value.'"';
}

try{
    $dbh=db_open();
    $sql='select * from words where userId="'.$_SESSION["userId"].'" && category in ('.$str.')';
    $statement=$dbh->query($sql);
    $count=$statement->rowCount();

    while($word=$statement->fetch()):
        array_push($quizData, $word);
    endwhile;

}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}

shuffle($quizData);

for($i=0; $i<$count; $i++){
    if($mode==1){
    $words[$i]=str2html($quizData[$i]["word"]);
    $meanings0[$i]=str2html($quizData[$i]["meaning"]);
    $meanings1[$i][0]=str2html($quizData[$i]["meaning"]);
    }else{
    $words[$i]=str2html($quizData[$i]["meaning"]);
    $meanings0[$i]=str2html($quizData[$i]["word"]);
    $meanings1[$i][0]=str2html($quizData[$i]["word"]);
    }
    $rand=array_rand($quizData,4);
    for($j=0; $j<=3; $j++){
        if($mode==1){
        $meanings1[$i][$j+1]=str2html($quizData[$rand[$j]]["meaning"]);
        }else{
        $meanings1[$i][$j+1]=str2html($quizData[$rand[$j]]["word"]);
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

?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Practice</title>
    
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/practice.css" rel="stylesheet">
    <link href="../assets/svg/memolis.ico" rel="shortcut icon">
    <link href="../assets/svg/memolis.ico" rel="icon">
</head>

<body>

<?php include "../include/header.php"; ?>

    <div class="quizContainer">

        <section class="result hidden"></section>

        <div class="bar">
            <div class="pageNum"></div>
        </div>

<?php

for($i=0; $i<=$qNum-1; $i+=1){
    echo '
        <section class="hidden quiz_area" id="echo'.$i.'">
            <div class="hidden move2next">
                <div>Click to continue...</div>
            </div>
    ';
    if($mode==1){
    echo '
        <p>What does <b>'.str2html($words[$i]).'</b> mean?</p>
    ';
    }else{
    echo '
        <p>Which term means <b>'.str2html($words[$i]).'</b>?</p>
    ';
    }

    echo '<div class="options">';

    for($j=0; $j<=3; $j+=1){
        if($meanings0[$i]==$meanings1[$i][$j]){
            echo '
                <div class="answer option">
                    <div class="optionFlex">
                        <img class="check invisible" src="../assets/svg/check.svg"/>
                        <span>'.str2html($meanings1[$i][$j]).'</span>
                    </div>
                </div>
            ';
        }else{
            echo '
                <div class="option">
                    <div class="optionFlex">
                        <img class="cross invisible" src="../assets/svg/x.svg"/>
                        <span>'.str2html($meanings1[$i][$j]).'</span>
                    </div>
                </div>
            ';
        }
    }
    echo '</div></section>';
}
?>
</div>
<script src="../index/init.js"></script>
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
<script src="../public/jquery-3.7.1.min.js"></script>
<script src="practice.js"></script>
<?php include "../include/footer.php"; ?>
</body>
</html>