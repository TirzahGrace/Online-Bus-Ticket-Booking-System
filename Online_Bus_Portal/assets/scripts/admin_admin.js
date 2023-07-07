const resultRows = document.querySelectorAll("tr");
const editBtns = document.querySelectorAll(".edit-button");
const deleteBtns = document.querySelectorAll(".delete-button");
const table = document.querySelector("table");
const addAdminForm = document.querySelector("#addAdminForm");


resultRows.forEach(row => 
    row.addEventListener("click", editOrDelete)  
);

if(table)
{
    table.addEventListener("click", collapseForm);
}

function collapseForm(evt){
    if(evt.target.className.includes("btn-close")){
        const collapseRow = evt.target.parentElement.parentElement.parentElement.parentElement;

        // enable the edit button
        const editBtn = collapseRow.previousElementSibling.children[6].children[0];
        editBtn.disabled = false;
        editBtn.classList.remove("disabled");

        // Collapse the row
        collapseRow.remove();
    }
}

function editOrDelete(evt){
    // if delete button is clicked
    if(evt.target.className.includes("delete-button"))
    {
        const deleteInput = document.querySelector("#delete-id");
        deleteInput.value = evt.target.dataset.id;
    }
}



function selectSuggestion(evt){
    if(evt.target.nodeName === "LI")
    {
        this.previousElementSibling.value = evt.target.innerText;
        this.innerText = "";
    }
}
