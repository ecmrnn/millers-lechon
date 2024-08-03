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

const addBtn = [
    "5",
    "20",
    "50",
    "60",
    "80",
    "100",
    "120",
    "200",
    "400",
    "800",
]

let addBtns = document.querySelector("#addBtns");
let addToggle = document.querySelector("#addToggle");
localStorage.setItem("addToggle", 0);

// Toggle button events
const showAddBtn = (btn) => {
    let button = document.createElement("button");
    let buttonClass = "add-balance px-3 py-2 rounded-md border border-slate-200 hover:bg-slate-50 transition-all ease-in-out".split(' ');
    let balance = document.forms["updateTable"]["balance"];

    button.classList.add(...buttonClass);
    button.setAttribute("data-value", btn);
    button.setAttribute("type", "button");
    if (localStorage.getItem("addToggle") == null || localStorage.getItem("addToggle") == 0) {
        button.innerHTML = `&plus; ${btn}`;
    } else {
        button.innerHTML = `&minus; ${btn}`;
    }

    button.addEventListener('click', () => {
        if (balance.value === "") {
            balance.value = parseInt(btn);        
        } else {
            if (localStorage.getItem("addToggle") == 0) {
                balance.value = parseFloat(balance.value) + parseInt(btn);
            } else {
                if (parseFloat(balance.value) - parseInt(btn) >= 0) {
                    balance.value = parseFloat(balance.value) - parseInt(btn);
                } else {
                    alert("Oops, nuyan may utang?");
                }
            }
        }
    })

    addBtns.appendChild(button);
}

const toggleAddBtn = () => {
    // 1 = false
    // 0 = true
    if (localStorage.getItem("addToggle") == null || localStorage.getItem("addToggle") == 0) {
        localStorage.setItem("addToggle", 1);
        addToggle.classList.remove("bg-green-500");
        addToggle.classList.add("bg-red-500");
        addToggle.innerHTML = 'Less';
    } else {
        localStorage.setItem("addToggle", 0);
        addToggle.classList.add("bg-green-500");
        addToggle.classList.remove("bg-red-500");
        addToggle.innerHTML = 'Add';
    }

    while (addBtns.hasChildNodes()) {
        addBtns.removeChild(addBtns.firstChild)
    }

    addBtn.forEach(btn => {
        showAddBtn(btn);
    });
}

addToggle.addEventListener('click', toggleAddBtn);
addBtn.forEach(btn => {
    showAddBtn(btn);
});

// Initialize localStorage
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

// Modal Events (Close & Open)
const closeModal = () => {
    modal.classList.remove("fixed");
    modal.classList.add("hidden");
}

const openModal = (item) => {
    localStorage.setItem("addToggle", 0);

    addToggle.innerHTML = 'Add';
    addToggle.classList.add("bg-green-500");
    addToggle.classList.remove("bg-red-500");

    while (addBtns.hasChildNodes()) {
        addBtns.removeChild(addBtns.firstChild)
    }

    addBtn.forEach(btn => {
        showAddBtn(btn);
    });

    modal.classList.remove("hidden");
    modal.classList.add("fixed");

    let tableNumber = document.querySelector("#tableNumber");
    let balance = document.forms["updateTable"]["balance"];
    
    balance.focus();
    tableNumber.innerHTML = item[0];
    balance.value = parseInt(localStorage.getItem(item[0]));
    
}

closeModalBtn.addEventListener("click", closeModal);

// Update Table Eventss (Update & Paid)
let update = document.forms["updateTable"]["update"]
update.addEventListener("click", () => {
    if (balance.value > 0) {
        localStorage.setItem(document.querySelector("#tableNumber").innerHTML, balance.value);
        redisplayTable();
    } else {
        alert('Balance must be greater than zero!');
    }
})

let paid = document.querySelector("#paid");
paid.addEventListener('click', () => {
    if (confirm("Sureball, bayad na?")) {
        let currentTable = document.querySelector("#tableNumber").innerHTML;
        localStorage.setItem(currentTable, 0)
        redisplayTable();
    }
})

let reset = document.querySelector("#reset");
reset.addEventListener('click', () => {
    if (confirm("Sureball?")) {
        tables.forEach(table => {
            localStorage.setItem(table[0], 0);
        });
        redisplayTable();
    }
})

// Display List of Tables
const showTables = item => {
    let section = document.querySelector("#tables");
    let button = document.createElement("button");
    let span = document.createElement("span");
    let h2 = document.createElement("h2");
    let p = document.createElement("p");
    let aClass = "table block p-3 rounded-md border text-center hover:shadow-lg transition-all ease-in-out".split(' ');

    if (parseInt(localStorage.getItem(item[0])) > 0) {
        aClass = "table block p-3 rounded-md border bg-slate-200 text-center".split(' ');
    }

    button.classList.add(...aClass);

    // Google Icon
    span.classList.add("material-symbols-outlined");
    span.innerHTML = "table_restaurant";

    h2.classList.add("font-bold");
    h2.innerHTML = `Table ${item[0]}`;
    
    p.classList.add("text-xs");
    p.innerHTML = `Balance: ${parseInt(localStorage.getItem(item[0])).toFixed(2).toLocaleString('en-US')}`;

    button.addEventListener("click", () => openModal(item))
    
    button.appendChild(span);
    button.appendChild(h2);
    button.appendChild(p);

    section.appendChild(button);
}

tables.forEach(item => {
    showTables(item);
});

const redisplayTable = () => {
    while (output.hasChildNodes()) {
        output.removeChild(output.firstChild)
    }

    tables.forEach(table => {
        showTables(table);
    })

    closeModal();
}