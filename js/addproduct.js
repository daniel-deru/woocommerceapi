
const categorySelect = document.getElementById("category")
const categoryList = document.getElementById("category-items")

const tagBtn = document.getElementById("tag-button")
const tagList = document.getElementById("tag-items")

let categoryItems = []
let tagItems = []

categorySelect.addEventListener("change",(event) => addCategories(event))
tagBtn.addEventListener("click", () => addTags())

function addCategories(event){
    
    let name = event.target.value

    if(!categoryItems.includes(name)){
        
        categoryItems.push(name) 
        displayCategories()
    }
   
}

function displayCategories(){

    while(categoryList.firstChild){
        categoryList.removeChild(categoryList.firstChild)
    }

    if(categoryItems.length > 0){
        for(let i = 0; i < categoryItems.length; i++){

            let listItem = document.createElement("li")
            let text = document.createTextNode(categoryItems[i])
            listItem.appendChild(text)
            listItem.addEventListener("click", (event) => deleteCategories(event))
            categoryList.appendChild(listItem)
        }
    }
}

function deleteCategories(event){
    categoryItems = categoryItems.filter(item => item != event.target.innerText)
    displayCategories()
}


function addTags(){
    let input = document.getElementById("tag-input")
    let name = input.value

    console.log(name)
    if(!tagItems.includes(name)){
        
        tagItems.push(name) 
        displayTags()
    }
    input.value = ""
   
}

function displayTags(){

    while(tagList.firstChild){
        tagList.removeChild(tagList.firstChild)
    }

    if(tagItems.length > 0){
        for(let i = 0; i < tagItems.length; i++){

            let listItem = document.createElement("li")
            let text = document.createTextNode(tagItems[i])
            listItem.appendChild(text)
            listItem.addEventListener("click", (event) => deleteTags(event))
            tagList.appendChild(listItem)
        }
    }
}

function deleteTags(event){
    tagItems = tagItems.filter(item => item != event.target.innerText)
    displayTags()
}