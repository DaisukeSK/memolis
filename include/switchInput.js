const select=$('input[type="radio"][value="select"]')
const add=$('input[type="radio"][value="add"]')

const selectDisable=(target,a)=>{
    target.parent().css('border', a? '2px solid transparent':'2px solid lightblue')
    target.siblings('select').attr('disabled',a)
    target.next().css('color',a? 'grey':'black')
}

const addDisable=(target,a)=>{
    target.parent().css('border', a? '2px solid transparent':'2px solid lightblue')
    target.siblings('label').css('color',a? 'grey':'black')
    target.siblings('input').attr('disabled',a)
    target.siblings('input').attr('placeholder',a? '':' Type a new category.')
    target.siblings('input').val('')
}

select.on('input',()=>{
    selectDisable(select,false)
    addDisable(add,true)
})

add.on('input',()=>{
    selectDisable(select,true)
    addDisable(add,false)
})

if(!$('select[name="category"]').children().length){
    select.css('pointerEvents','none')
    add.attr('checked',true)
    selectDisable(select,true)
    addDisable(add,false)
}else{
    selectDisable(select,false)
    addDisable(add,true)
}