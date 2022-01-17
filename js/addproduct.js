
const categorySelect = document.getElementById("category")
const categoryList = document.getElementById("category-items")

const tagBtn = document.getElementById("tag-button")
const tagList = document.getElementById("tag-items")

let categoryItems = []
let tagItems = []
let imageSet = false

categorySelect.addEventListener("change",(event) => addCategories(event))
tagBtn.addEventListener("click", () => addTags())


const saveBtn = document.getElementById("save-btn")
saveBtn.addEventListener("click", () => saveClicked())

const imageUpload = document.getElementById("image")
imageUpload.addEventListener("change", (event) => showImage(event))

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
    const hiddenCategories = document.getElementById("hidden-categories")
    const hiddenTags = document.getElementById("hidden-tags")
    const categories = Array.from(document.getElementById("category-items").children).map(category => category.innerText).join("%")
    const tags = Array.from(document.getElementById("tag-items").children).map(tag => tag.innerText).join("%")
    hiddenCategories.value = categories
    hiddenTags.value = tags
}

function deleteTags(event){
    tagItems = tagItems.filter(item => item != event.target.innerText)
    displayTags()
}

function showImage(event){
    console.log(event.target.files)
    let output = document.getElementById("img")
    output.src = URL.createObjectURL(event.target.files[0])
    imageSet = true
}

function saveClicked(){
    const name = document.getElementById("name").value
    const regularPrice = document.getElementById("regular-price").value
    const salePrice = document.getElementById("sale-price").value
    const productType = document.getElementById("product-type").value
    const virtual = document.getElementById("virtual").checked
    const downloadable = document.getElementById("downloadable").checked
    const image = document.getElementById("img")
    const description = document.getElementById("description").value
    const shortDescription = document.getElementById("short-description").value
    const sku = document.getElementById("sku-input").value
    const categories = Array.from(document.getElementById("category-items").children).map(category => category.innerText).join("%")
    const tags = Array.from(document.getElementById("tag-items").children).map(tag => tag.innerText).join("%")

    const errors = document.getElementById("errors")

    while(errors.firstChild){
        errors.removeChild(errors.firstChild)
    }

    if(!imageSet){
        let error = document.createElement("div")
        error.appendChild(document.createTextNode("Please set an image."))
        errors.appendChild(error)
    }
}