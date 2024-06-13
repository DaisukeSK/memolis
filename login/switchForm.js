const form1=$(".form1")
const form2=$(".form2")
const newAccountP=$(".newAccountP")

$("section").css('height',form2.css("height"))

const formWidth=+form1.css("width").split("px")[0]
const formMargin=30

form2.css('left',window.innerWidth/2+formWidth+formMargin)

$('.createNewAccount').on('click',()=>{

    form1.animate({
        left: window.innerWidth/2-formWidth-formMargin,
        opacity: 0
    }, 700);

    form2.animate({
        left: `50%`,
        opacity: 1
    }, 700);

    newAccountP.animate({
        opacity: 0
    }, 700);

    setTimeout(()=>{
        form1.css('pointer-events','none')
        form2.css('pointer-events','auto')
        newAccountP.css('pointer-events','none')
    },700)
})

$('.form2 svg').on('click',()=>{
    form1.animate({
        left: `50%`,
        opacity: 1
    }, 700);

    form2.animate({
        left: window.innerWidth/2+formWidth+formMargin,
        opacity: 0
    }, 700);

    newAccountP.animate({
        opacity: 1
    }, 700);

    setTimeout(()=>{
        form1.css('pointer-events','auto')
        form2.css('pointer-events','none')
        newAccountP.css('pointer-events','auto')
    },700)
})