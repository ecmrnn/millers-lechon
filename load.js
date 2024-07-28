// Add ulam here...
let ulam = [
    "Sinigang (Baboy)",
    "Lechon Sisig",
    "Lechon Paksiw",
    "Dinuguan",
    "Chopsuey",
    "Ampalaya",
    "Menudo",
    "Mechado",
    "Hamonado",
    "Isda",
    "Bopis",
    "Adobo (Baboy)",
    "Adobong Sitaw",
    "Lumpiang Toge",
    "Puso ng Saging",
];

ulam.sort();

let output = document.querySelector("#ulams");

ulam.forEach(u => {
    let label = document.createElement("label");
    let input = document.createElement("input");
    let p = document.createElement("p");

    let label_class = "ulam-label select-none flex items-center gap-5 border rounded-md px-3 py-2 cursor-pointer".split(' ');

    label.setAttribute("for", u);
    label.classList.add(...label_class);

    input.setAttribute("type", "checkbox");
    input.setAttribute("id", u);

    p.classList.add("capitalize");
    p.innerHTML = `<strong>${u}</strong><span></span>`;

    label.appendChild(input)
    label.appendChild(p)

    output.appendChild(label)
});