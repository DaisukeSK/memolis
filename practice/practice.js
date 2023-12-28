"use strict";
$(document).ready(function(){

let questions=$(".question b");
let answer=$(".correctA .optionWord");
let answers=[];

const correctBG="#A7F4A7"
const correctBD="1px #58E958 solid"

const wrongBG="#F9C7C7"
const wrongBD="1px #F28080 solid"

console.log("LENGTH",length)
console.log("LENGTH-Q",questions.length)

//console.log("quiz_area",$(".quiz_area").css("height"))

let areaWidth=0;
//let areaHeight=0;
//$(".barFrame .bar").css("width",0)
$(".quiz_area").each(function(){
    //console.log("width:",+$(this).css("width").split("px")[0])
    //console.log("-----index",index,areaWidth)
    const width=+$(this).css("width").split("px")[0]
    if(width>areaWidth){
        areaWidth=width;
        //console.log("updated",areaWidth)
    }
    //$(".quiz_area").css("width","753px")
    // if(+$(this).css("height").split("px")[0]>areaHeight){
    //     areaHeight=+$(this).css("height").split("px")[0];
    //     //console.log("updated",areaWidth)
    // }
})

// $(".quiz_area, .barFrame, #next, .link, .container1").each(function(){
$("main").css("width",areaWidth+"px")

    //$(this).css("height",areaHeight+"px")
    //console.log("width changed",$(this).css("width"))


//$(".barFrame").css("height","5px")
//$(".link").css("height","auto")
//$(".container1").css("height","210px")
// $("#next").css("width",areaWidth+"px")
//console.log("width barFrame",$(".barFrame").css("width"))
//const barWidth=+$(".barFrame").css("width").split("px")[0]
//console.log("barWidth",barWidth)
const devide=questions.length




// $("#result").css("height",$(".quiz_area").css("height"))
// $("#result").css("height",0)
//$("#result").css("display","none")

// answer.each((aaa)=>{
//     console.log("Answer: ",answer[aaa].innerText)
// })
// questions.each((aaa)=>{
//     console.log("Q: ",questions[aaa].innerText)
// })

// $(".start").on("click", function(){
    $(".pageNum").text("1/"+length)
    //$("header").css("display","block")
    
    //$("#result").css("height","fit-content")
    //let dd="echo0";
    // $(this).remove();
    $(".barFrame .bar").css("width",areaWidth/length)
    //$(this).addClass("hidden");
    // console.log("removed",this)
    //$("#page").removeClass("hidden");
    $("#echo0").removeClass("hidden");

    
    
    

// });

let current=0;
let correct=0;

/*
function pagenum(){
    if(current<length){
document.getElementById("page").textContent=`${current+1}/${length}`;
}else{
    document.getElementById("page").textContent=`Your score: ${correct} out of ${length}.`;
}
}*/


$(".quiz_area .option").on("click", function(){
    //$("#next").css("height",$(".quiz_area").css("height"))
    //$("#next").css("height",$(this).parents(".quiz_area").css("height"))

    let match=false;
    //const answer=$(".correctA")
    //$(".correct").removeClass("hidden");
    //$(".wrong").removeClass("hidden");

    //$("#next").removeClass("hidden");
    //$(".check").removeClass("invisible");
    console.log("parent",$(this).closest(".quiz_area").find(".move2next"))
    $(this).closest(".quiz_area").find(".move2next").removeClass("hidden");

    $(this).parent().find(".correctA").css("background-color",correctBG)
    $(this).parent().find(".correctA").css("border",correctBD)
    $(this).parent().find(".correctA img").removeClass("invisible");

    // $(".correctA").style.backgroundColor="#3294F5";
    //$(".correctA").css("background-color","#3294F5")
    
    //this.parentElement.querySelector(".correctA").style.backgroundColor="lightgreen";
    if($(this).hasClass("correctA")){
        //console.log("this:",this.style.color)
        //this.style.backgroundColor="#3294F5";
        //$(".correct_or_wrong").text("correct!!!!!");
        
        match=true;
        correct+=1;
    }else{
        $(this).css("background-color",wrongBG)
        $(this).css("border",wrongBD)
        //this.style.backgroundColor="pink";
        //console.log("sibling:",this.parentElement.querySelector(".correctA"))
        //this.parentElement.querySelector(".correctA").style.backgroundColor="#3294F5";
        //$(".correct_or_wrong").text("wrong!!!!!");
        //$(".check").removeClass("hidden");
        //$(this >".wrong").removeClass("hidden");
        $(this).find(".cross").removeClass("invisible");
    }
    answers.push({match:match,selected:$(this).find(".optionWord").text()});
    console.log("array:",answers)
});


$(".move2next").on("click", function(){
    //$(".next").on("click", function(){
        
        
        $(this).addClass("hidden");
        $(".check").addClass("invisible");
        $(".cross").addClass("invisible");
    
        // $("#echo"+current).addClass("hidden");
        $("#echo"+current).remove();
            current+=1;
        $("#echo"+current).removeClass("hidden");
        $(".barFrame .bar").css("width",(current+1)*areaWidth/length)
        //$("#echo"+current).removeClass("hidden");
        console.log("clicked 2",$("#echo"+current))
        $(".pageNum").text(current+1+"/"+length)

        if(current==length){
            showResult();
        };
    });



function showResult(){
    
    //$("#page").text(`${current+1}/${length}`);

    console.log("LENGTH-A",answers.length)
    $("#result").removeClass("hidden");
    $(".barFrame .bar").addClass("hidden");
    //$("#result").removeClass("hidden");
    //console.log("mode:",questions[0].classList[0]);
    // $("#result").text(`Your score: ${correct} out of ${length}.`);
    for(let i=0; i<length; i++){
        let match, bgColor, bdColor;
        
        if(answers[i].match==true){
            // match=`<span style="color:green"><b>✔</b></span>`;
            match=`<img src="../assets/svg/check.svg"/>`;
            bgColor=correctBG
            bdColor=correctBD
        }else{
            // match=`<span style="color:red"><b>x</b></span>`;
            match=`<img src="../assets/svg/x.svg"/>`;
            bgColor=wrongBG
            bdColor=wrongBD
        }

        let inserted1;
        if(questions[0].classList[0]=="mode1"){
            inserted1=`<div class="resultDiv">${match}&nbsp;<u>${i+1}. What does <b>${questions[answers.length-i-1].textContent}</b> mean?</u></div>`;
        }else{
            inserted1=`<div class="resultDiv">${match}&nbsp;<u>${i+1}. Which word means <b>${questions[answers.length-i-1].textContent}</b>?</u></div>`;
        }

        let inserted=`
        <div class="resultGrid" style="background-color:${bgColor}; border:${bdColor}">
            ${inserted1}
            <div style="margin-left:30px">Your answer:</div><div>${answers[i].selected}</div>
            <div style="margin-left:30px">Correct answer:</div><div>${answer[answers.length-i-1].textContent}</div>
        </div>
        `;
        document.querySelector(".results").insertAdjacentHTML("beforeend",inserted);
    }
    const score=`
    <div class="score">
    Your score: <span class="score1"><b>${correct}</b></span> out of <span class="score2"><b>${length}</b></span>.
    </div>
    `;
    document.querySelector("#result").insertAdjacentHTML("afterbegin",score);
    //$("#result").text(``);
    console.log("result width",$("#result").css("width"))
    
    // $("header").css("width",$("#result").css("width"))
    
    //console.log("innerHeight",getComputedStyle(document.querySelector("section#result")).height)
    document.querySelector("body").style.height=+(getComputedStyle(document.querySelector("section#result")).height).split("px")[0]+200+"px";
}
//showResult();




});