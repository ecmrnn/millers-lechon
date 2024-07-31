// Add table here...
// [0] Table #
// [1] Balance 
let tables = [
    [1, 0],
    [2, 0],
    [3, 0],
    [4, 0],
    [5, 0],
    [6, 0],
]

const setup = () => {
    tables.forEach(table => {
        if (localStorage.getItem(table[0]) == 0 || localStorage.getItem(table[0]) == null) {
            localStorage.setItem(table[0], table[1]);
        }
    });
}

setup();

let output = document.querySelector("#tables");
let modal = document.querySelector("#modal");
let closeModalBtn = document.querySelector("#close");

const closeModal = () => {
    modal.classList.remove("fixed");
    modal.classList.add("hidden");
}

const openModal = (item) => {
    modal.classList.remove("hidden");
    modal.classList.add("fixed");

    let tableNumber = document.querySelector("#tableNumber");
    let balance = document.forms["updateTable"]["balance"];
    
    balance.focus();
    tableNumber.innerHTML = item[0];
    balance.value = localStorage.getItem(item[0]);
    
}

let update = document.forms["updateTable"]["update"]

update.addEventListener("click", () => {
    if (balance.value > 0) {
        localStorage.setItem(document.querySelector("#tableNumber").innerHTML, balance.value);
    
        while (output.hasChildNodes()) {
            output.removeChild(output.firstChild)
        }
    
        tables.forEach(table => {
            showTables(table);
        })
    
        closeModal();
    } else {
        alert('Balance must be greater than zero!');
    }
})

let paid = document.querySelector("#paid");

paid.addEventListener('click', () => {
    let currentTable = document.querySelector("#tableNumber").innerHTML;
    localStorage.setItem(currentTable, 0)
    while (output.hasChildNodes()) {
        output.removeChild(output.firstChild)
    }

    tables.forEach(table => {
        showTables(table);
    })

    closeModal();
})

closeModalBtn.addEventListener("click", closeModal);

const showTables = item => {
    let section = document.querySelector("#tables");
    let a = document.createElement("a");
    let span = document.createElement("span");
    let h2 = document.createElement("h2");
    let p = document.createElement("p");

    let aClass = "table block p-3 rounded-md border text-center hover:shadow-lg transition-all ease-in-out".split(' ');

    a.classList.add(...aClass);
    a.setAttribute("href", "#");

    // Google Icon
    span.classList.add("material-symbols-outlined");
    span.innerHTML = "table_restaurant";

    h2.classList.add("font-bold");
    h2.innerHTML = `Table ${item[0]}`;
    
    p.classList.add("text-xs");
    p.innerHTML = `Balance: ${parseInt(localStorage.getItem(item[0])).toFixed(2).toLocaleString('en-US')}`;

    a.addEventListener("click", () => openModal(item))

    a.appendChild(span);
    a.appendChild(h2);
    a.appendChild(p);

    section.appendChild(a);
}

tables.forEach(item => {
    showTables(item);
});