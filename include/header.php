<div class="instructionBG">
    <div class="window">
        <div class="x">
            <img src="../assets/svg/x2.svg"/>
        </div>

        <h2>Welcome to memolis.</h2>

        <p>
            memolis is a digital word-book app.<br/>
            <h3>1. Register a pair of a term and definition.</h3>

            Click<u><?php include "../assets/svgConversion/add2.html";?>Add data</u> 
            button and it takes you to a registration page.<br/>
            In this page, you can register a pair of term, definition and category that you want to memorize, the data is saved in database.<br/>
            You can browse all data in <u><?php include "../assets/svgConversion/home2.html";?>Home</u> page anytime.<br/>

            You also have <?php include "../assets/svgConversion/pen.html";?>
            button to edit and <?php include "../assets/svgConversion/delete2.html";?>
            button to delete each data.<br/>
            
            <h3>2. Play practice mode.</h3>
            Click <u><?php include "../assets/svgConversion/practice2.html";?>Practice</u> button and
            Select categories, mode and the number of question and click start.<br/>
            You can play quiz with 4 options, try your best!

            <h3>3. What is coming next?</h3>
            <div class="thumbUp">
                <span>Stay tuned, there is more to come</span>
                <?php include "../assets/svgConversion/thumb-up.html";?>
            </div>
        </p>
    </div>
</div>

<header>
    <div class="hedearLeft">
        <a class="logoAnchor" href='../index/index.php'>
            <img class="logo" src="../assets/svg/memolis4LogoOnly.svg"/>
        </a>
        <div class="colmnFlex">
            <h3>Hi, <?php echo $_SESSION["userName"];?></h3>
        </div>
    </div>

    <div class="hedearRight">
        <div class="help">
            <?php include "../assets/svgConversion/help.html";?>
        </div>
        <a href='../index/index.php'>
            <?php include "../assets/svgConversion/home.html";?>
            Home
        </a>
        <a href='../include/input.php'>
            <?php include "../assets/svgConversion/add.html";?>
            Add Data
        </a>
        <a href='../practice/practice_pre.php'>
            <?php include "../assets/svgConversion/practice.html";?>
            Practice
        </a>
        <a href='../login/logout.php'>
            <?php include "../assets/svgConversion/logout.html";?>
            Log Out
        </a>
        <a href='../index/account_delete.php' onclick='return confirm("Are you sure that you want to delete account?")'>
            <?php include "../assets/svgConversion/delete3.html";?>
            Delete account
        </a>
    </div>
</header>

<script src='../public/jquery-3.7.1.min.js'></script>
<script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
<script>

    const anchors=$('.hedearRight a')
    const p=$('a[href="../practice/practice_pre.php"]')

    anchors.each(function(){
        if(location.href.includes($(this).attr('href').split('../')[1])){
            $(this).css('pointerEvents','none')
            // $(this).css('background','linear-gradient(transparent, #FF008A)')
            $(this).css('background','#ffffff55')
        }
    })

    if(location.href.includes('practice')){
        p.css('pointerEvents','none')
        // p.css('background','linear-gradient(transparent, #FF008A)')
        p.css('background','#ffffff55')
    }

    $('.help svg').on('click', ()=>{
        $('.instructionBG').css('display','block')
    })

    $('.x').on('click', ()=>{
        $('.instructionBG').css('display','none')
    })

</script>