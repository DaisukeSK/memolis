// const select=document.querySelector('select[name="category"]');
// const input=document.querySelector('input[name="newCategory"]');

// const hideInput=()=>{
//     if(select.value!=="NewCategory"){
//         input.style.display="none"
//         input.value=""
//     }else{
//         input.style.display="block"
//     }
// };

// hideInput();
// // window.onload=()=>{
// // };
// select.onchange=()=>{
//     hideInput();
// };


// const flexChild=document.querySelectorAll('.flexChild');

// flexChild[0].onclick=(e)=>{
//     e.target.closest(".flexChild").style.backgroundColor="lightblue"
//     e.target.querySelector("select").disabled=false

//     flexChild[1].closest(".flexChild").style.background="none"
//     flexChild[1].querySelector("input").disabled=true
// }

// flexChild[1].onclick=(e)=>{
//     e.target.closest(".flexChild").style.backgroundColor="lightblue"
//     e.target.querySelector("input").disabled=false

//     flexChild[0].closest(".flexChild").style.background="none"
//     flexChild[0].querySelector("select").disabled=true
// }

const radiosForCategory=document.querySelectorAll('input[type="radio"][name="select_add"]');
// console.log("R",radiosForCategory)
// radiosForCategory.forEach(val=>{
//     val.oninput=(e)=>{

//         console.log(e.target)
//     }
// })
const inputDisabled=(target)=>{
    target.closest(".flexChild").style.outline="2px solid lightblue";
    target.closest(".flexChild").querySelector("select").disabled=false;
    target.closest(".flexChild").querySelector('label').style.color="black";
    
    radiosForCategory[1].closest(".flexChild").style.outline="none";
    radiosForCategory[1].closest(".flexChild").querySelector('input[type="text"]').disabled=true;
    radiosForCategory[1].closest(".flexChild").querySelector('input[type="text"]').value=""
    radiosForCategory[1].closest(".flexChild").querySelector('input[type="text"]').placeholder=""
    
    radiosForCategory[1].closest(".flexChild").querySelector('label').style.color="grey";

}

inputDisabled(radiosForCategory[0])

radiosForCategory[0].oninput=(e)=>{
    inputDisabled(e.target)
    // e.target.closest(".flexChild").style.outline="2px solid lightblue";
    // e.target.closest(".flexChild").querySelector("select").disabled=false;
    // e.target.closest(".flexChild").querySelector('label').style.color="black";

    // radiosForCategory[1].closest(".flexChild").style.outline="none";
    // radiosForCategory[1].closest(".flexChild").querySelector('input[type="text"]').disabled=true;
    // radiosForCategory[1].closest(".flexChild").querySelector('input[type="text"]').value=""
    // radiosForCategory[1].closest(".flexChild").querySelector('input[type="text"]').placeholder=""

    // radiosForCategory[1].closest(".flexChild").querySelector('label').style.color="grey";
}

radiosForCategory[1].oninput=(e)=>{
    e.target.closest(".flexChild").style.outline="2px solid lightblue";
    e.target.closest(".flexChild").querySelector('input[type="text"]').disabled=false;
    e.target.closest(".flexChild").querySelector('input[type="text"]').placeholder=" Type a new category."
    e.target.closest(".flexChild").querySelector('label').style.color="black";

    radiosForCategory[0].closest(".flexChild").style.outline="none";
    radiosForCategory[0].closest(".flexChild").querySelector('select').disabled=true;

    radiosForCategory[0].closest(".flexChild").querySelector('label').style.color="grey";
}