const ul = document.querySelector('.dataList');
// const topLi=document.querySelector(".topLi")
const liCaption=document.querySelector(".liCaption")
const noHit=document.querySelector(".noHit")

// ul.insertAdjacentElement("afterbegin",noHit)
// ul.insertAdjacentElement("afterbegin",liCaption)
// ul.insertAdjacentElement("afterbegin",topLi)
document.querySelector(".topLi").insertAdjacentElement("afterend",liCaption)


const searchInput=document.querySelector('input.searchInput')


////////////////////// Category //////////////////////
const category = document.querySelector('select[name="category"]');

const dataLi = document.querySelectorAll('.dataLi');



category.onchange=(e)=>{
    console.log("viewport:",window.innerHeight)
    noHit.style.display="none"
    searchInput.value=""
    console.log("----------------------------")
    //console.log("dataLi:",dataLi)
    // console.log("Changed",e.target.value);
    // console.log("dataLi",dataLi)
    dataLi.forEach(data=>{

        console.log("e: ",e.target.value)
        console.log("data: ",data.querySelector("div.liCategory").textContent)
        console.log("data: ",data)

        
        
        // if(e.target.value=="Category"){
        //     console.log("All: ",e.target.value)
        //     console.log("All: ",data.querySelector("div.liCategory").textContent)
        //     data.style.display="flex";
        // }else if(e.target.value!==data.querySelector("div.liCategory").textContent){
        //     console.log("Not match: ",e.target.value)
        //     console.log("Not match: ",data.querySelector("div.liCategory").textContent)
        //     data.style.display="none";
        // }else if(e.target.value==data.querySelector("div.liCategory").textContent){
        //     console.log("Match: ",e.target.value)
        //     console.log("Match: ",data.querySelector("div.liCategory").textContent)
        //     data.style.display="flex";
        // }

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
            
            //console.log("direction",b,consition)

            if(consition){
                //console.log("Case")
                shouldSwitch=true
                break;
            }
        }
        if(shouldSwitch){
            //console.log("done")
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
    console.log("Changed",e.target.value);
    console.log("length",dataLi.length);
    // console.log("dataLi",dataLi)


    // if(e.target.value=="a-z"){
    //     selectChangeHandler("div.liTerm","left");
    // }else if(e.target.value=="z-a"){
    //     selectChangeHandler("div.liTerm","right");
    // }else{
    //     selectChangeHandler("id","right");
    // }

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
    console.log("Changed",e.target.value);
    console.log("length",dataLi.length);
    // console.log("dataLi",dataLi)
    // if(e.target.value=="old"){
    //     selectChangeHandler("div.liTime","left");
    // }else if(e.target.value=="new"){
    //     selectChangeHandler("div.liTime","right");
    // }else{
    //     selectChangeHandler("id","right");
    // }
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
        //console.log("checked: true")
        checkbox.forEach(v=>{
            //console.log("parent:",v.parentNode.style.display)
            // if(v.parentNode.style.display!=="none"){
            //     v.checked=true    
            // }
            v.parentNode.style.display!=="none" && (v.checked=true)
            //v.checked=true
        })
    }else{
        deleteSubmit.style.display="none"
        //console.log("checked: false")
        checkbox.forEach(v=>{
            v.checked=false
        })
    }
}

document.querySelector('input[name="multipleDeletion"]').onmouseover=()=>{
    //console.log("mouseover")
    deleteText.style.display="block"
}
document.querySelector('input[name="multipleDeletion"]').onmouseleave=()=>{
    //console.log("mouseover")
    deleteText.style.display="none"
}




checkbox.forEach(val=>{
    val.onchange=(e)=>{
        deleteSubmit.style.display="none"
        checkbox.forEach(val2=>{
            val2.checked ? deleteSubmit.style.display="flex" : checkboxAll.checked=false
            
            // if(val2.checked){
            //     deleteSubmit.style.display="block"
            // }else{

            //     checkboxAll.checked=false
            // }
            
        })

    }
})

////////////////////// no data //////////////////////
console.log("ul children",ul.children.length)
// if(ul.children.length==3){
//     // ul.insertAdjacentHTML("beforeend",'<li class="dataLi noData"><div>No data</div></li>')
// }
ul.children.length==3 &&
ul.insertAdjacentHTML("beforeend",'<li class="dataLi noData"><div>No data</div></li>')

////////////////////// search //////////////////////



//const noHit=document.querySelector('li.noHit')
const lis=document.querySelectorAll(".liTerm, .liDefinition")
//const temp=document.querySelectorAll(".temp")
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
        console.log("input",e.target.value)
    }
    init()
    //const aa=dataLi[0]

    ////////// forEach //////////

    let hitCount=0;

    
    
    dataLi.forEach(val=>{
        let temp;
        const elmnt=val.querySelectorAll(".liTerm, .liDefinition")
        function insertTemp(num,classes,insert){
            console.log("parent",elmnt[num].parentNode,elmnt[num].closest(".dataLi"))
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
            

            if(classes=="wordTemp"){
                temp='<div class="temp '+classes+'"><b>'+bb+'</b></div>'

            }else{
                temp='<div class="temp '+classes+'">'+bb+'</div>'
            }
            // if(classes=="wordTemp"){
            //     temp='<div class="temp '+classes+'">'+split[0]+'<mark>'+e.target.value+'</mark>'+split[1]+'</div>'

            // }else{
            //     temp='<div class="temp '+classes+'">'+split[0]+'<mark>'+e.target.value+'</mark>'+split[1]+'</div>'
            // }
            elmnt[num].parentNode.insertAdjacentHTML(insert,temp)

        }
        //console.log("dataLi",dataLi[0].querySelector(".liTerm").textContent)
        // if(elmnt[0].textContent.includes(e.target.value) || elmnt[1].textContent.includes(e.target.value)){
        if(!elmnt[0].textContent.includes(e.target.value) && !elmnt[1].textContent.includes(e.target.value)){
            val.style.display="none"
        }else{
            if(elmnt[0].textContent.includes(e.target.value)){
                insertTemp(0,"wordTemp","afterbegin")
                
            }
            if(elmnt[1].textContent.includes(e.target.value)){
                insertTemp(1,"meaningTemp","beforeend")
                
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
        console.log("mouseover",e.target.closest("a").nextElementSibling)
        
        // e.target.closest("a").nextElementSibling.style.display="block"
        e.target.closest("a").querySelector(".editDelete").style.display="block"

        
        
    }
    anchor.onmouseleave=(e)=>{
        //e.target.closest("a").querySelector("svg").setAttribute("fill","black")
        // e.target.closest("a").nextElementSibling.textContent=""
        // e.target.closest("a").nextElementSibling.style.display="none"
        e.target.closest("a").querySelector(".editDelete").style.display="none"
    }
})
