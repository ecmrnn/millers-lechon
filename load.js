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

const showUlam = u => {
    let label = document.createElement("label");
    let input = document.createElement("input");
    let p = document.createElement("p");

    let labelClass = "ulam-label select-none flex items-center gap-2 sm:gap-5 border rounded-md px-3 py-2 cursor-pointer".split(' ');

    label.setAttribute("for", u);
    label.classList.add(...labelClass);

    input.setAttribute("type", "checkbox");
    input.setAttribute("id", u);

    p.classList.add("line-clamp-1");
    p.innerHTML = `<strong>${u}</strong><span></span>`;

    label.appendChild(input)
    label.appendChild(p)

    output.appendChild(label)
}

ulam.forEach(u => {
    showUlam(u);
});

// search
const search = document.querySelector("#search");
search.addEventListener('keyup', () => {
    // remove every ulam in the list
    while (output.hasChildNodes()) {
        output.removeChild(output.firstChild);
    }

    // display searched ulam
    ulam.forEach(u => {
        if (u.toLowerCase().search(search.value.toLowerCase()) != -1) {
            showUlam(u);
        }
    });
    // console.log("Adobong Sitaw".search(search.value));
})