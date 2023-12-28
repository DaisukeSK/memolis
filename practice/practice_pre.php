<?php
session_start();
require_once "../require/login_status_check.php";
require_once "../require/function.php";

// var_dump($_SESSION["data"]);

// var_dump($_SESSION["dataCategory"]);
// echo "<br/>"."length".count($_SESSION["data"])."<br/>";
// echo "<br/>"."length".count($_SESSION["dataCategory"])."<br/>";
// echo '
// <link href="../css/common.css" rel="stylesheet">
// <link href="practice_pre.css" rel="stylesheet">
// ';

// echo '<body>';

// include "../include/header.php";
// echo '
// <!--<div class="link">
//     <a href="../index.php">Home</a><br>
// </div>-->

// <div class="container1">

//     <form action="practice.php" method="post">
//         <h2>Let&apos;s Practice!</h2>
//         <section class="modeSection">
//             <label class="title">Select Mode</label>
//             <div class="divRadio">
//                 <input type="radio" name="id" value="1" checked/><label>Term -> Meaning</label><br/>
//                 <input type="radio" name="id" value="2"/><label>Meaning -> Term</label>
//             </div>
//         </section>
        
//         <section class="categorySection">
//             <label class="title">Select Categories</label>
//             <input type="checkbox" value="all" checked/>Select all<br/>
// ';

// try{
    // $dbh=db_open();
    // $sql='select category from words where user="'.$_SESSION["username"].'"';
    // $statement=$dbh->query($sql);

    // $noCategory=false;
    // $noCategoryCount=0;
    // while($row=$statement->fetch()):
    //     if($row[0]=="-"){
    //         $noCategory=true;
    //         $noCategoryCount+=1;
    //     }
    // endwhile;

    //$count=$statement->rowCount();
    $dataCount=count($_SESSION["data"]);
    if($dataCount<4){
        echo '<script>alert("At least 4 pieces of data are required for practice.")</script>';
        echo '<script>location.href="../login/login.php"</script>';
        exit;
    }else{
        echo '
        <link href="../css/common.css" rel="stylesheet">
        <link href="../css/practice_pre.css" rel="stylesheet">
        <link href="../assets/svg/memolis.ico" rel="shortcut icon">
        <link href="../assets/svg/memolis.ico" rel="icon">
        
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
        // $sql='select category from categories where user="'.$_SESSION["username"].'"';
        // $result=$dbh->query($sql);
        // $dataCount=$noCategoryCount;
        
        // while($row=$result->fetch()):


        //     $sql2='select id from words where category="'.$row[0].'"';
        //     $result2=$dbh->query($sql2);
        //     $count2=$result2->rowCount();
        //     //echo 'count: '.$row[0].' : '.$count2;

        //     $dataCount+=$count2;


            foreach($_SESSION["dataCategory"] as $value){

                

                $count=0;
                foreach($_SESSION["data"] as $value2){
                    if($value2[2]==$value){
                        $count++;
                    }

                }


                echo '
                <div class="divCategory">
                    <input class="num'.$count.'" type="checkbox" name="categories[]" value="'.$value.'" checked/><label>'.$value.' ('.$count.')</label>
                </div>
                ';
            }

        //endwhile;
        // if($noCategory==true){
        //     //echo 'count: - : '.$noCategoryCount;
        //     echo '
        //     <div class="divCategory">
        //         <input class="num'.$noCategoryCount.'" type="checkbox" name="categories[]" value="-" checked/><label>-,'.$noCategoryCount.'</label>
        //     </div>
        //     ';
        // }
        echo '</section>';




        echo '
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
                        <span class="maxNum">&#91;1-'.$dataCount.'&#93;</span>
                        
                    </label>
                    <div class="qNumberFlex">
                        <input name="num" class="showTotal" type="range" min="1" max="'.$dataCount.'" value="'.$dataCount.'"/>
                        <div class="showTotal">'.$dataCount.'</div>
                    </div>
                </section>
                </div>
            </div>
        ';

    }
    // }catch(PDOException $e){
    //     echo "Error: ".str2html($e->getMessage())."<br>";
    //     exit;
    // }

echo '
    <input type="submit" value="start"/>
    </form>
</div>
';

include "../include/footer.php";

echo '</body>';
?>

<script src="../index/init.js"></script>
<script type="text/javascript">
    const totalNum=<?php echo $dataCount;?>;
    console.log("totalNum",totalNum)
    //const checkBoxes=document.querySelectorAll('input[type="checkbox"]')
    const selectAllCategories=document.querySelector('input[value="all"][type="checkbox"]')
    const categories=document.querySelectorAll('input[name="categories[]"]')
    const divShowTotal=document.querySelector('div.showTotal')
    const inputShowTotal=document.querySelector('input.showTotal')
    const maxNum=document.querySelector('span.maxNum')
    const qNumAlert=document.querySelector('.qNumAlert')
    const submitButton=document.querySelector('input[type="submit"]')
    
    //console.log("all:",selectAllCategories)
    selectAllCategories.onchange=(e)=>{
        //console.log("all:",e.target.checked)
        
        if(e.target.checked){
            inputShowTotal.disabled=false
            submitButton.disabled=false
            divShowTotal.textContent=totalNum;
            
            maxNum.textContent='[1-'+totalNum+']';
            inputShowTotal.max=totalNum
            inputShowTotal.value=totalNum;
            qNumAlert.style.display="none"
            //console.log("true")
            categories.forEach(val=>{
                val.checked=true;
            })
        }else{
            divShowTotal.textContent=0;
            maxNum.textContent='[0]';
            //inputShowTotal.max=0
            //inputShowTotal.value=0;
            qNumAlert.style.display="block"
            inputShowTotal.disabled=true
            submitButton.disabled=true
            //console.log("false")
            categories.forEach(val=>{
                val.checked=false;
            })
        }
       
    }

    categories.forEach(val=>{
        val.onchange=(e)=>{
            console.log("--------------")
            //console.log("val:",e.target.checked)
            if(!e.target.checked){
                selectAllCategories.checked=false;
            }
            let total=0;
            categories.forEach(val=>{
                if(val.checked){
                    console.log(+val.classList[0].split("num")[1])
                    total+=+val.classList[0].split("num")[1]
                }
            })
            console.log("Total:",total)
            divShowTotal.textContent=total;
            maxNum.textContent='[1-'+total+']';
            

            if(total<4){
                if(total==0){
                    maxNum.textContent='[0]';
                }else{
                    inputShowTotal.max=total
                    inputShowTotal.value=total;
                }
                
                qNumAlert.style.display="block"
                inputShowTotal.disabled=true
                submitButton.disabled=true
            }else{
                inputShowTotal.disabled=false
                submitButton.disabled=false
                qNumAlert.style.display="none"
                inputShowTotal.max=total
                inputShowTotal.value=total;
            }
            
        }
    })

    inputShowTotal.onchange=(e)=>{
        console.log("range",e.target.value)
        divShowTotal.textContent=e.target.value;

    }
    inputShowTotal.oninput=(e)=>{
        console.log("range",e.target.value)
        divShowTotal.textContent=e.target.value;

    }

    

    
</script>

<!-- <div class="container">
    <h1>Practice</h1>
    <h2>Mode 1</h2>
    <a href="practice.php?id=1">word→meaning</a>
    <h2>Mode 2</h2>
    <a href="practice.php?id=2">meaning→word</a>
</div> -->