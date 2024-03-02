const form_1=$(".form_1")
const form_2=$(".form_2")
const formFlex=$(".formFlex")
const newAccountP=$(".newAccountP")

$('.createNewAccount').on('click',()=>{
    formFlex.css('animationName','shift')
    form_1.css('animationName','toHidden')
    form_2.css('animationName','toVisible')
    newAccountP.css('animationName','toHidden')
})

$('.form_2 svg').on('click',()=>{
    formFlex.css('animationName','shiftBack')
    form_1.css('animationName','toVisible')
    form_2.css('animationName','toHidden')
    newAccountP.css('animationName','toVisible')
})