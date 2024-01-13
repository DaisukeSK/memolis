let answers=[];

const correctBG="#A7F4A7"
const correctBD="1px #58E958 solid"

const wrongBG="#F9C7C7"
const wrongBD="1px #F28080 solid"

let areaWidth=0;

$(".quiz_area").each(function(){
    const width=+$(this).css("width").split("px")[0]
    if(width>areaWidth){
        areaWidth=width;
    }
})

$(".quizContainer").css("width",areaWidth+"px")
$(".pageNum").text("1/"+length)
$(".bar").css("width",areaWidth/length+"px")
$("#echo0").removeClass("hidden");

let current=0;
let correct=0;

$(".quiz_area .option").on("click", function(){

    let match=false;

    $(this).closest(".quiz_area").find(".move2next").removeClass("hidden");
    $(this).parent().find(".answer").css("background-color",correctBG)
    $(this).parent().find(".answer").css("border",correctBD)
    $(this).parent().find(".answer img").removeClass("invisible");

    if($(this).hasClass("answer")){
        match=true;
        correct+=1;
    }else{
        $(this).css("background-color",wrongBG)
        $(this).css("border",wrongBD)
        $(this).find(".cross").removeClass("invisible");
    }
    answers.push({
        match: match,
        selected: $(this).find("span").text()
    });
});

$(".move2next").on("click", function(){
    current+=1;

    $(this).parent().remove();
    $("#echo"+current).removeClass("hidden");
    $(".bar").css("width",(current+1)*areaWidth/length+"px")
    $(".pageNum").text(current+1+"/"+length)

    current==length && showResult();
});

function showResult(){

    $(".bar").remove();
    $(".result").removeClass("hidden");

    for(let i=0; i<length; i++){
        let match, bgColor, bdColor;
        
        if(answers[i].match==true){
            match=`<img src="../assets/svg/check.svg"/>`;
            bgColor=correctBG
            bdColor=correctBD
        }else{
            match=`<img src="../assets/svg/x.svg"/>`;
            bgColor=wrongBG
            bdColor=wrongBD
        }

        let inserted1 = mode==1?
            `<div class="resultDiv">${match}&nbsp;<u>${i+1}. What does <b>${qArray[i]}</b> mean?</u></div>`:
            `<div class="resultDiv">${match}&nbsp;<u>${i+1}. Which term means <b>${qArray[i]}</b>?</u></div>`;

        let inserted=`
            <div class="resultGrid" style="background-color:${bgColor}; border:${bdColor}">
                ${inserted1}
                <div style="margin-left:30px">Your answer:</div>
                <div>${answers[i].selected}</div>
                <div style="margin-left:30px">Correct answer:</div>
                <div>${rightAnswers[i]}</div>
            </div>
        `;
        $(".result").append(inserted)
    }

    const score=`
        <div class="score">
            Your score:&nbsp;
            <span class="score1">
                <b>${correct}</b>
            </span> out of&nbsp;
            <span class="score2">
                <b>${length}</b>
            </span>
        </div>
    `;
    $(".result").prepend(score)
    $("body").css("height", +($("section.result").css("height")).split("px")[0]+200+"px");
}