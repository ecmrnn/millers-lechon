// Add table here...
let tables = [
    // [0] Table #
    // [1] Balance 
    [1, 0],
    [2, 0],
    [3, 0],
    [4, 0],
    [5, 0],
    [6, 0],
]

{/* <a href="#" class="">
    <span class="material-symbols-outlined">table_restaurant</span>
    <h2 class="font-bold">Table 1</h2>
    <p class="text-xs">Balance: 200.00 Php</p>
</a> */}

let output = document.querySelector("#tables");

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
    p.innerHTML = `Balance: ${item[1].toFixed(2).toLocaleString('en-US')}`;

    a.appendChild(span);
    a.appendChild(h2);
    a.appendChild(p);

    section.appendChild(a);
}

tables.forEach(item => {
    showTables(item);
});