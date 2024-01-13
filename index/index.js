const ul = document.querySelector('.dataList');
const liCaption=document.querySelector(".liCaption")
const noHit=document.querySelector(".noHit")
document.querySelector(".topLi").insertAdjacentElement("afterend",liCaption)

const searchInput=document.querySelector('input.searchInput')

////////////////////// Category //////////////////////
const category = document.querySelector('select[name="category"]');
const dataLi = document.querySelectorAll('.dataLi');

category.onchange=(e)=>{

    noHit.style.display="none"
    searchInput.value=""
    
    dataLi.forEach(data=>{

        switch(e.target.value){
            case "Category":
                data.style.display="flex";
                break;

            case data.querySelector("div.liCategory").textContent:
                data.style.display="flex";
                break;

            default :
            data.style.display="none";
        }
    })
}

////////////////////// Function //////////////////////

const selectChangeHandler=(a,b)=>{
    let i, switching, shouldSwitch, consition;
        
    switching=true;

    while(switching){
        switching=false;
        const li=ul.querySelectorAll('li.dataLi');

        for(i=0; i<li.length-1; i++){
            shouldSwitch=false

            if(a=="id"){
                consition=+li[i].id > +li[i+1].id
            }else{

                if(b=="left"){
                    consition=li[i].querySelector(a).textContent.toLowerCase()>
                        li[i+1].querySelector(a).textContent.toLowerCase()

                }else{
                    consition=li[i].querySelector(a).textContent.toLowerCase()<
                        li[i+1].querySelector(a).textContent.toLowerCase()
                }
            }

            if(consition){
                shouldSwitch=true
                break;
            }
        }
        if(shouldSwitch){
            ul.insertBefore(li[i+1],li[i])
            switching=true
        }
    }
}

const alphabetically = document.querySelector('select[name="alphabetically"]');
const lastUpdated = document.querySelector('select[name="lastUpdated"]');

////////////////////// alphabetically //////////////////////
alphabetically.onchange=(e)=>{
    lastUpdated.value="default";

    switch(e.target.value){
        case "a-z":
            selectChangeHandler("div.liTerm","left");
            break;
        case "z-a":
            selectChangeHandler("div.liTerm","right");
            break;
        default:
            selectChangeHandler("id","right");
    }
}

////////////////////// lastUpdated //////////////////////
lastUpdated.onchange=(e)=>{
    alphabetically.value="default";
    
    switch(e.target.value){
        case "old":
            selectChangeHandler("div.liTime","left");
            break;

        case "new":
            selectChangeHandler("div.liTime","right");
            break;

        default:
            selectChangeHandler("id","right");
    }
}

////////////////////// checkbox //////////////////////
const checkbox=document.querySelectorAll('input[name="id[]"]')
const checkboxAll=document.querySelector('input[name="delete"]')
const deleteSubmit=document.querySelector('.divSubmit')
const deleteText=document.querySelector('.divSubmitRight')

checkboxAll.onchange=(e)=>{
    if(e.target.checked){
        deleteSubmit.style.display="flex"
        checkbox.forEach(v=>{
            v.parentNode.style.display!=="none" && (v.checked=true)
        })
    }else{
        deleteSubmit.style.display="none"
        checkbox.forEach(v=>{
            v.checked=false
        })
    }
}

document.querySelector('input[name="multipleDeletion"]').onmouseover=()=>{
    deleteText.style.display="block"
}
document.querySelector('input[name="multipleDeletion"]').onmouseleave=()=>{
    deleteText.style.display="none"
}

checkbox.forEach(val=>{
    val.onchange=(e)=>{
        deleteSubmit.style.display="none"
        checkbox.forEach(val2=>{
            val2.checked ? deleteSubmit.style.display="flex" : checkboxAll.checked=false
        })
    }
})

////////////////////// no data //////////////////////
ul.children.length==3 &&
ul.insertAdjacentHTML("beforeend",'<li class="dataLi noData"><div>No data</div></li>')

////////////////////// search //////////////////////
const lis=document.querySelectorAll(".liTerm, .liDefinition")

searchInput.oninput=(e)=>{

    ////////// Initial execution //////////
    const init=()=>{
        lis.forEach(val=>{
            val.style.display="block"
        })
        document.querySelectorAll(".temp").forEach(val=>{
            val.remove()
        })
        category.value="Category"
    }
    init()

    ////////// forEach //////////

    let hitCount=0;

    dataLi.forEach(val=>{
        let temp;
        const elmnt=val.querySelectorAll(".liTerm, .liDefinition")
        function insertTemp(num,classes,insert){

            elmnt[num].style.display="none"
            const split=elmnt[num].textContent.split(e.target.value)

            let bb="";
            split.forEach((val,key)=>{
                if(split.length==key+1){
                    bb+=val
                }else{
                    bb+=val+'<mark>'+e.target.value+'</mark>'
                }
            })
            
            if(classes=="termTemp"){
                temp='<div class="temp '+classes+'"><b>'+bb+'</b></div>'

            }else{
                temp='<div class="temp '+classes+'">'+bb+'</div>'
            }
            
            elmnt[num].parentNode.insertAdjacentHTML(insert,temp)
        }
        
        if(!elmnt[0].textContent.includes(e.target.value) && !elmnt[1].textContent.includes(e.target.value)){
            val.style.display="none"
        }else{
            if(elmnt[0].textContent.includes(e.target.value)){
                insertTemp(0,"termTemp","afterbegin")
            }
            if(elmnt[1].textContent.includes(e.target.value)){
                insertTemp(1,"definitionTemp","beforeend")
            }
            noHit.style.display="none"
            val.style.display="flex"
            hitCount++;
        }
    })

    if(!hitCount){
        console.log("No hit",noHit)
        noHit.style.display="block"
    }

    if(e.target.value==""){
        init()
    }
}

document.querySelectorAll(".editDeleteAnchor").forEach(anchor=>{
    anchor.onmouseover=(e)=>{
        e.target.closest("a").querySelector(".editDelete").style.display="block"
    }
    anchor.onmouseleave=(e)=>{
        e.target.closest("a").querySelector(".editDelete").style.display="none"
    }
})