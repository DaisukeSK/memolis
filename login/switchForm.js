// const goRight=document.querySelector(".createNewAccount")
// const goLeft=document.querySelector(".form_2 svg")
const form_1=document.querySelector(".form_1")
const form_2=document.querySelector(".form_2")
const formFlex=document.querySelector(".formFlex")
const newAccountP=document.querySelector(".newAccountP")

// console.log("",(window.innerWidth-form_1.getBoundingClientRect().width)/2)

document.querySelector(".createNewAccount").onclick=()=>{
    // formFlex.style.transform="translateX(-156px)";
    

    
    formFlex.style.animationName="shift"
    form_1.style.animationName="toHidden"
    form_2.style.animationName="toVisible"
    newAccountP.style.animationName="toHidden"
   
}

document.querySelector(".form_2 svg").onclick=()=>{
    // formFlex.style.transform="translateX(-498px)";
    // form_1.style.visibility="visible"
    
    formFlex.style.animationName="shiftBack"
    form_1.style.animationName="toVisible"
    form_2.style.animationName="toHidden"
    newAccountP.style.animationName="toVisible"
    
    // form_2.style.visibility="hidden"
    
}