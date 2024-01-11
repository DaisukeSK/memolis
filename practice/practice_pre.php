<?php
session_start();
require_once "../require/login_status_check.php";
require_once "../require/function.php";

// $dataCount=count($_SESSION["data"]);

// echo $_SESSION["dataCount"]."<br/>";
// echo $dataCount."<br/>";
// exit;

if($_SESSION["dataCount"]<4){
    echo '
    <script>
        alert("At least 4 pairs of data are required for practice mode.")
        location.href="../index/index.php"
    </script>
    ';
    exit;
}

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Practice</title>
    <meta charset="utf-8">
    <link href="../css/common.css" rel="stylesheet">
    <link href="../css/practice_pre.css" rel="stylesheet">
    <link href="../assets/svg/memolis.ico" rel="shortcut icon">
    <link href="../assets/svg/memolis.ico" rel="icon">
</head>
<body>
';

include "../include/header.php";

$form=<<<EDO
<div class="container">
    <form action="practice.php" method="post">
        <h2>Let&apos;s Practice!!!</h2>
        <div class="practiceConfig">
            <section class="categorySection">
                <label class="title">Select Categories</label>
                    <input type="checkbox" value="all" checked/>Select all<br/>
EDO;

echo $form;



try{

    $dbh=db_open();
    $sql='select * from categories where userId=:userId';
    $stmt=$dbh->prepare($sql);
    $stmt->bindParam(':userId', $_SESSION["userId"], PDO::PARAM_INT);
    $stmt->execute();

    

    while($row=$stmt->fetch()):

        $sql2='select * from words where userId=:userId and categoryId=:categoryId';
        $stmt2=$dbh->prepare($sql2);
        $stmt2->bindParam(':userId', $_SESSION['userId'], PDO::PARAM_INT);
        $stmt2->bindParam(':categoryId', $row["id"], PDO::PARAM_INT);
        $stmt2->execute();

        $rowCount=$stmt2->rowCount();

        echo '
        <div class="divCategory">
            <input class="num'.$rowCount.'" type="checkbox" name="categories[]" value="'.$row["id"].'" checked/><label>'.$row["category"].' ('.$row["id"].",".$rowCount.')</label>
        </div>
        ';


    endwhile;


    

}catch(PDOException $e){
    echo "Error: ".str2html($e->getMessage())."<br>";
    exit;
}



?>

</section>

<div class="sectionFlex">

    <section class="modeSection">
        <label class="title">Select Mode</label>
        <div class="divRadio">
            <div class="flex">
                <input type="radio" name="mode" value="1" checked/>&nbsp;
                <label>Term&nbsp;</label>
                <img src="../assets/svg/arrow.svg">
                <label>&nbsp;Definition</label>
            </div>
            <div class="flex">
                <input type="radio" name="mode" value="2"/>&nbsp;
                <label>Definition&nbsp;</label>
                <img src="../assets/svg/arrow.svg">
                <label>&nbsp;Term</label>
            </div>
        </div>
    </section>

    <section class="qNumber">
        <div class="qNumAlert" style="color:red; display:none">At least 4 data is required.</div>
        <label class="title">
            <span>Number of questions</span>
            <span class="maxNum">&#91;1-<?php echo $_SESSION["dataCount"];?>&#93;</span>
        </label>
        <div class="qNumberFlex">
            <?php echo '<input name="num" type="range" min="1" max="'.$_SESSION["dataCount"].'" value="'.$_SESSION["dataCount"].'"/>'?>
            <div class="showTotal"><?php echo $_SESSION["dataCount"];?></div>
        </div>
    </section>
    </div><!-- sectionFlex -->
</div><!-- practiceConfig -->

<?php

echo '
    <input type="submit" value="start"/>
    </form>
    </div><!-- container -->
';
include "../include/footer.php";

?>

</body>

<script src="../index/init.js"></script>
<script type="text/javascript">

    const totalNum=<?php echo $_SESSION["dataCount"];?>;
    const allCategories=document.querySelector('input[value="all"][type="checkbox"]')
    const categories=document.querySelectorAll('input[name="categories[]"]')
    const divShowTotal=document.querySelector('div.showTotal')
    const inputShowTotal=document.querySelector('input[name="num"][type="range"]')
    const maxNum=document.querySelector('span.maxNum')
    const qNumAlert=document.querySelector('.qNumAlert')
    const submitButton=document.querySelector('input[type="submit"]')

    categories.forEach(val=>{
        val.onchange=(e)=>{
            !e.target.checked && (allCategories.checked=false)
            let total=0;
            categories.forEach(val=>{
                if(val.checked){
                    console.log(+val.classList[0].split("num")[1])
                    total+=+val.classList[0].split("num")[1]
                }
            })
            divShowTotal.textContent=total;
            maxNum.textContent=total==0?'[0]':total==1?'[1]':'[1-'+total+']';
            inputShowTotal.max=total
            inputShowTotal.value=total;

            if(total<4){
                qNumAlert.style.display="block"
                inputShowTotal.disabled=true
                submitButton.disabled=true
            }else{
                inputShowTotal.disabled=false
                submitButton.disabled=false
                qNumAlert.style.display="none"
            }
        }
    })

    allCategories.onchange=(e)=>{
        if(e.target.checked){
            inputShowTotal.disabled=false
            submitButton.disabled=false
            divShowTotal.textContent=totalNum;
            maxNum.textContent='[1-'+totalNum+']';
            inputShowTotal.max=totalNum
            inputShowTotal.value=totalNum;
            qNumAlert.style.display="none"

            categories.forEach(val=>{
                val.checked=true;
            })
        }else{
            divShowTotal.textContent=0;
            maxNum.textContent='[0]';
            qNumAlert.style.display="block"
            inputShowTotal.disabled=true
            submitButton.disabled=true

            categories.forEach(val=>{
                val.checked=false;
            })
        }
    }

    inputShowTotal.onchange=(e)=>{
        divShowTotal.textContent=e.target.value;
    }
    inputShowTotal.oninput=(e)=>{
        divShowTotal.textContent=e.target.value;
    }

</script>