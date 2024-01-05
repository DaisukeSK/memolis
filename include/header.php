
<div class="instruction">

    <div class="window">

        <div class="x">
            <img src="../assets/svg/x2.svg"/>
        </div>

        <h2>Welcome to memolis.</h2>

        <p>
            memolis was created to help you memorize words, idioms, proverbs and so on.<br/>

            <h3>1. Register a pair of a term and definition.</h3>

            Click<u><?php include "../assets/svgConversion/add2.html";?>Add data</u> 
            button and it takes you to a registeration page.<br/>
            In the page, type a term, definition and category that you want to memorize and submit, and it is saved in database.<br/>
            You can browse all data that you registered in <u><?php include "../assets/svgConversion/home2.html";?>Home</u> page.<br/>

            You also have 
            <?php include "../assets/svgConversion/pen.html";?>
            button to edit and 
            <?php include "../assets/svgConversion/delete2.html";?>
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

    <div class="headerBG"></div>

    <div class="hedearLeft">
            <a class="logoAnchor" href='../index/index.php'>
                <img class="logo" src="../assets/svg/memolis4LogoOnly.svg"/>
            </a>
        <div class="colmnFlex">
            <h3>Hi, <?php echo $_SESSION["username"];?></h3>
        </div>
    </div>

    <div class="hedearRight">

        <div class="a_hover anchor help">
            <?php include "../assets/svgConversion/help.html";?>
        </div>

        <div class="a_hover anchor">
            <?php include "../assets/svgConversion/home.html";?>
            <a class="anchorRight" href='../index/index.php'>Home</a>
        </div>

        <div class="a_hover anchor">
            <?php include "../assets/svgConversion/add.html";?>
            <a class="anchorRight" href='../include/input.php'>Add Data</a>
        </div>

        <div class="a_hover anchor">
            <?php include "../assets/svgConversion/practice.html";?>
            <a class="anchorRight" href='../practice/practice_pre.php'>Practice</a>
        </div>

        <div class="a_hover anchor">
            <?php include "../assets/svgConversion/logout.html";?>
            <a class="anchorRight" href='../login/logout.php'>Log Out</a>
        </div>

        <div class="a_hover anchor">
            <?php include "../assets/svgConversion/delete3.html";?>
            <a class="anchorRight" href='../index/account_delete.php' onclick='return confirm("Are you sure that you want to delete account?")'>Delete account</a>
        </div>

    </div>

</header>

<script>

    const anchors=document.querySelectorAll(".anchorRight")

    anchors.forEach(val=>{
        if(val.href==location.href){
            val.style.pointerEvents="none"
            val.parentElement.classList.remove("a_hover");

            val.parentElement.style.backgroundColor="rgba(255,255,255,0.3)"
            val.parentElement.style.border="2px solid rgba(255,255,255,0.7)"
        }
        if(location.href.includes("practice.php")){
            anchors[2].parentElement.style.backgroundColor="rgba(255,255,255,0.3)"
            anchors[2].parentElement.style.border="2px solid rgba(255,255,255,0.7)"
        }
    })

    document.querySelector(".help svg").onclick=()=>{
        document.querySelector(".instruction").style.display="block"
    }

    document.querySelector(".instruction .x").onclick=()=>{
        document.querySelector(".instruction").style.display="none"
    }

</script>