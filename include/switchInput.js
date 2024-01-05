const radiosForCategory=document.querySelectorAll('input[type="radio"][name="select_add"]');


const selectCategoryDisable=(target,a)=>{
    target.parentNode.style.outline= a? "none":"2px solid lightblue";
    target.parentNode.querySelector("select").disabled= a? true:false;
    target.nextElementSibling.style.color= a? "grey":"black";
}
const newCategoryDisable=(target,a)=>{
    target.parentNode.style.outline= a? "none":"2px solid lightblue";
    target.parentNode.querySelector('input[type="text"]').disabled= a? true:false;
    target.parentNode.querySelector('input[type="text"]').value=""
    target.parentNode.querySelector('input[type="text"]').placeholder= a? "":" Type a new category."
    target.nextElementSibling.style.color= a? "grey":"black";
}



radiosForCategory[0].oninput=(e)=>{
    selectCategoryDisable(e.target,false)
    newCategoryDisable(radiosForCategory[1],true)
}
radiosForCategory[1].oninput=(e)=>{
    selectCategoryDisable(radiosForCategory[0],true)
    newCategoryDisable(e.target,false)
}


newCategoryDisable(radiosForCategory[1],true)