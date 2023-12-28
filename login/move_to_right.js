const aa=document.querySelector("span.createNewAccount")
const form_1=document.querySelector(".form_1")
const form_2=document.querySelector(".form_2")
const cc=document.querySelector("div.xxx")
const formFlex=document.querySelector(".formFlex")
const newAccountP=document.querySelector(".newAccountP")

aa.onclick=()=>{
    formFlex.style.transform="translateX(-156px)";
    

    
    formFlex.style.animationName="nadge"
    form_1.style.animationName="toHidden"
    newAccountP.style.animationName="toHidden"
    form_2.style.animationName="toVisible"
   
}

cc.onclick=()=>{
    formFlex.style.transform="translateX(-498px)";
    // form_1.style.visibility="visible"
    
    formFlex.style.animationName="nadgeBack"
    form_1.style.animationName="toVisible"
    newAccountP.style.animationName="toVisible"
    form_2.style.animationName="toHidden"
    
    // form_2.style.visibility="hidden"
    
}

