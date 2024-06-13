let answers=[];

const correctBG="#A7F4A7"
const correctBD="1px #58E958 solid"

const wrongBG="#F9C7C7"
const wrongBD="1px #F28080 solid"

const areaWidth=$(".quizContainer").css("width").split('px')[0];

console.log("areaWidth",areaWidth)

$(".pageNum").text("1/"+length)
$(".bar").css("width",areaWidth/length+"px")
$("#echo0").show();

let current=0;
let correct=0;

$(".quiz_area .option").on("click", function(){

    let match=false;

    $(this).closest(".quiz_area").find(".move2next").css("display","flex");
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
    $("#echo"+current).show();

    // Need to get width below for every question because width changes when scroll bar shows up on the right.
    const areaWidth2=$(".quizContainer").css("width").split('px')[0];

    $(".bar").css("width",(current+1)*areaWidth2/length+"px")
    $(".pageNum").text(current+1+"/"+length)

    current==length && showResult();
});

function showResult(){

    $(".bar").remove();
    $(".result").show();

    for(let i=0; i<length; i++){
        let match, bgColor, bdColor;
        
        if(answers[i].match==true){
            match=`<img src="../assets/images/check.svg"/>`;
            bgColor=correctBG
            bdColor=correctBD
        }else{
            match=`<img src="../assets/images/x.svg"/>`;
            bgColor=wrongBG
            bdColor=wrongBD
        }

        const inserted1 = mode==1?
            `<div class="question">${match}&nbsp;<u>${i+1}. What does <b>${qArray[i]}</b> mean?</u></div>`:
            `<div class="question">${match}&nbsp;<u>${i+1}. Which term means <b>${qArray[i]}</b>?</u></div>`;

        const inserted=`
            <div class="resultDiv" style="background-color:${bgColor}; border:${bdColor}">
                ${inserted1}
                <div class='answer'>
                    <span style='color:${answers[i].match?'#17AD00':'#FF3333'}'>Your answer:</span>
                    <span>${answers[i].selected}</span>
                </div>
                <div class='answer'>
                    <span style='color:${answers[i].match?'#17AD00':'#FF3333'}'>Correct answer:</span>
                    <span>${rightAnswers[i]}</span>
                </div>
            </div>
        `;
        $(".result").append(inserted)
    }

    const score=`
        <div class="score">
            <span>Your score:&nbsp;</span>
            <span>
                <span class="score1">
                    <b>${correct}</b>
                </span>
                    out of&nbsp;
                <span class="score2">
                    <b>${length}</b>
                </span>
            </span>
        </div>
    `;
    $(".result").prepend(score)
}