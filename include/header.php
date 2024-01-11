
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

    <!-- <div class="headerBG"></div> -->

    <div class="hedearLeft">
            <a class="logoAnchor" href='../index/index.php'>
                <img class="logo" src="../assets/svg/memolis4LogoOnly.svg"/>
            </a>
        <div class="colmnFlex">
            <h3>Hi, <?php echo $_SESSION["username"];?></h3>
        </div>
    </div>

    <div class="hedearRight">

        <div class="help">
            <?php include "../assets/svgConversion/help.html";?>
        </div>

        <!-- <div class="a_hover anchor"> -->
            <a href='../index/index.php'>
                <?php include "../assets/svgConversion/home.html";?>
                
            Home</a>
        <!-- </div> -->

        <!-- <div class="a_hover anchor"> -->
            <a href='../include/input.php'>
                
                <?php include "../assets/svgConversion/add.html";?>
            Add Data</a>
        <!-- </div> -->

        <!-- <div class="a_hover anchor"> -->
            <a href='../practice/practice_pre.php'>
                <?php include "../assets/svgConversion/practice.html";?>
                
            Practice</a>
        <!-- </div> -->

        <!-- <div class="a_hover anchor"> -->
            <a href='../login/logout.php'>
                <?php include "../assets/svgConversion/logout.html";?>
                
            Log Out</a>
        <!-- </div> -->

        <!-- <div class="a_hover anchor"> -->
            <a href='../index/account_delete.php' onclick='return confirm("Are you sure that you want to delete account?")'>
                <?php include "../assets/svgConversion/delete3.html";?>
            
            Delete account</a>
        <!-- </div> -->

    </div>

</header>

<script>

    const anchors=document.querySelectorAll(".hedearRight a")

    anchors.forEach(a=>{
        if(a.href==location.href){
            a.style.pointerEvents="none"
            // val.classList.remove("a_hover");

            // a.style.backgroundColor="rgba(255,255,255,0.3)"
            a.style.background="linear-gradient(transparent, #FF008A)"


            // a.style.border="2px solid rgba(255,255,255,0.7)"
        }
    })
    if(location.href.includes("practice.php")){
        anchors[2].style.background="linear-gradient(transparent, #FF008A)"
        // anchors[2].style.border="2px solid rgba(255,255,255,0.7)"
    }

    document.querySelector(".help svg").onclick=()=>{
        document.querySelector(".instructionBG").style.display="block"
    }

    document.querySelector(".instructionBG .x").onclick=()=>{
        document.querySelector(".instructionBG").style.display="none"
    }

</script>