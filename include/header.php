<div class="instructionBG">
    <div class="window">
        <div class="x">
            <img src="../assets/images/x2.svg"/>
        </div>

        <h2>Welcome to memolis</h2>

        <p>
            memolis is a digital word-book app.<br/>
            <h3>1. Register a pair of a term and definition.</h3>

            Click&nbsp;<u><?php include "../assets/svg/add.html";?>&nbsp;Add data</u> 
            button and it takes you to a registration page.<br/>
            In this page, you can register a pair of term, definition and category that you want to memorize, the data is saved in database.<br/>
            You can browse all data in&nbsp;<u><?php include "../assets/svg/home.html";?>&nbsp;Home</u> page anytime.<br/>

            You also have&nbsp;<?php include "../assets/svg/pen.html";?>&nbsp;
            button to edit and&nbsp;<?php include "../assets/svg/delete.html";?>&nbsp;
            button to delete each data.<br/>
            
            <h3>2. Play practice mode.</h3>
            Click&nbsp;<u><?php include "../assets/svg/practice.html";?>&nbsp;Practice</u> button and
            Select categories, mode and the number of question and click start.<br/>
            You can play quiz with 4 options, try your best!

            <h3>3. What is coming next?</h3>
            Stay tuned, there is more to come
            <?php include "../assets/svg/thumb-up.html";?>
        </p>
    </div>
</div>

<header>
    <div class="hedearLeft">
        <a class="logoAnchor" href='../index/index.php'>
            <img class="logo" src="../assets/images/memolis4LogoOnly.svg"/>
        </a>
        <h3>Hi, <?php echo $_SESSION["userName"];?></h3>
    </div>

    <div class="hedearRight">
        <div class="help">
            <?php include "../assets/svg/help.html";?>
        </div>
        <a href='../index/index.php'>
            <?php include "../assets/svg/home.html";?>
            Home
        </a>
        <a href='../include/input.php'>
            <?php include "../assets/svg/add.html";?>
            Add Data
        </a>
        <a href='../practice/practice_pre.php'>
            <?php include "../assets/svg/practice.html";?>
            Practice
        </a>
        <a href='../login/logout.php'>
            <?php include "../assets/svg/logout.html";?>
            Log Out
        </a>
        <a href='../index/account_delete.php?token=<?php echo $_SESSION['token']; ?>' onclick='return confirm("Are you sure that you want to delete account?")'>
            <?php include "../assets/svg/delete.html";?>
            Delete account
        </a>
    </div>
    <svg class='hamburger' width='33' height='24'>
        <rect x='0' y='0' width='33' height='4' fill='#ffffff'/>
        <rect x='0' y='10' width='33' height='4' fill='#ffffff'/>
        <rect x='0' y='20' width='33' height='4' fill='#ffffff'/>
    </svg>
</header>
<aside>
    <svg class='hamburgerAside' width='33' height='24'>
        <rect x='0' y='0' width='33' height='4' fill='#ffffff'/>
        <rect x='0' y='10' width='33' height='4' fill='#ffffff'/>
        <rect x='0' y='20' width='33' height='4' fill='#ffffff'/>
    </svg>
    <div class="help">
        <?php include "../assets/svg/help.html";?>
        About this app
    </div>
    <a href='../index/index.php'>
        <?php include "../assets/svg/home.html";?>
        Home
    </a>
    <a href='../include/input.php'>
        <?php include "../assets/svg/add.html";?>
        Add Data
    </a>
    <a href='../practice/practice_pre.php'>
        <?php include "../assets/svg/practice.html";?>
        Practice
    </a>
    <a href='../login/logout.php'>
        <?php include "../assets/svg/logout.html";?>
        Log Out
    </a>
    <a href='../index/account_delete.php?token=<?php echo $_SESSION['token']; ?>' onclick='return confirm("Are you sure that you want to delete account?")'>
        <?php include "../assets/svg/delete.html";?>
        Delete account
    </a>

</aside>

<script src='../public/jquery-3.7.1.min.js'></script>
<script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
<script>

    const anchors=$('.hedearRight a, aside a')

    $('.hamburger').on('click', ()=>{
        $('aside').animate({
            right: 0
        },500)
    })
    $('.hamburgerAside').on('click', ()=>{
        $('aside').animate({
            right: '-200px'
        },500)
    })

    anchors.each(function(){

        const dest=location.href.split('.php')[0].split('/')
        console.log("location:",dest[dest.length-1])
        console.log("location2:",$(this).attr('href').split('../')[1])
        if($(this).attr('href').split('../')[1].includes(dest[dest.length-1]) && !$(this).attr('href').includes('account_delete')){
            $(this).css('pointerEvents','none')
            $(this).css('background','#ffffff55')
        }
    })

    $('.help').on('click', ()=>{
        $('.instructionBG').css('display','block')
    })

    $('.x').on('click', ()=>{
        $('.instructionBG').css('display','none')
    })

</script>