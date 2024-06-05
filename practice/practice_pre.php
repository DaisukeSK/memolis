<?php
session_start();
require_once "../require/login_status_check.php";
require_once "../require/function.php";

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
            <input class="num'.$rowCount.'" type="checkbox" name="categories[]" value="'.$row["id"].'" checked/><label>'.$row["category"].' ('.$rowCount.')</label>
        </div>
        ';
    endwhile;

}catch(PDOException $e){
    echo "Error: ".$e->getMessage()."<br>";
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
        <div class="alert" style="color:red; display:none">At least 4 data is required.</div>
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

<script src='../public/jquery-3.7.1.min.js'></script>
<script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
<script type="text/javascript">

    const totalNum =  <?php echo $_SESSION["dataCount"];?>;
    const allCategories = $('input[value="all"][type="checkbox"]')
    const categories = $('input[name="categories[]"]')
    const totalInput = $('input[name="num"][type="range"]')
    const totalDiv = $('div.showTotal')
    const maxNum = $('span.maxNum')
    const alert = $('.alert')
    const submitBtn = $('input[type="submit"]')

    categories.each(function(){

        $(this).on('change',()=>{

            !$(this).is(':checked') && (allCategories.prop('checked',false))
            let total=0;

            categories.each(function(){
                $(this).is(':checked') && (total+=+$(this).attr('class').split("num")[1])
            })

            totalDiv.text(total);
            maxNum.text(total==0?'[0]':total==1?'[1]':'[1-'+total+']');
            totalInput.attr('max',total)
            totalInput.val(total)

            if(total<4){
                alert.css('display','block')
                totalInput.attr('disabled',true)
                submitBtn.attr('disabled',true)
            }else{
                totalInput.attr('disabled',false)
                submitBtn.attr('disabled',false)
                alert.css('display','none')
            }
        })
    })

    allCategories.on('input',()=>{

        if(allCategories.is(':checked')){
            totalInput.attr('disabled',false)
            submitBtn.attr('disabled',false)
            totalDiv.text(totalNum);
            maxNum.text('[1-'+totalNum+']');
            totalInput.attr('max',totalNum)
            totalInput.val(totalNum)
            alert.css('display','none')

            categories.each(function(){
                $(this).prop('checked',true)
            })

        }else{
            totalDiv.text(0);
            maxNum.text('[0]');
            alert.css('display','block')
            totalInput.attr('disabled',true)
            submitBtn.attr('disabled',true)

            categories.each(function(){
                $(this).prop('checked',false)
            })
        }
    })

    totalInput.on('input',()=>{
        totalDiv.text(totalInput.val());
    })

    totalInput.on('change',()=>{
        totalDiv.text(totalInput.val());
    })

</script>