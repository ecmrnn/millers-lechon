// Add ulam here...
let ulam = [
    "Sinigang na Baboy",
    "Lechon Sisig",
    "Lechon Paksiw",
    "Dinuguan",
    "Chopsuey",
    "Ampalaya",
    "Menudo",
    // Removed Mechado
    "Hamonado",
    "Gatang Tilapia",
    "Bopis",
    "Adobong Baboy",
    "Gatang Sitaw", /* From Adobong Sitaw */
    "Lumpiang Toge",
    "Puso ng Saging",
    // Added on: 28/07/2024
    "Bicol Express",
    "Binagoongan",
    "Kalabasa",
    "Gatang Hipon",
    "Paksiw na Bangus",
];

ulam.sort();

let output = document.querySelector("#ulams");

const showUlam = u => {
    let textarea = document.querySelector("#output");
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

    if (textarea.innerHTML.search(u) != -1) {
        input.checked = true;
    }
    

    // add click event on ulam 
    input.addEventListener('change', () => {
        const name = input.nextElementSibling.children[0].innerHTML;
        const price = input.nextElementSibling.children[1].innerHTML;
        const currentText = textarea.innerHTML;
        
        if (input.checked) {
            textarea.innerHTML = "";
            textarea.innerHTML = currentText + `- ${name} ${price}\n`;
        } else {
            const currentItem = `- ${name} ${price}`;
            const index = textarea.innerHTML.indexOf(currentItem);

            textarea.innerHTML = "";
            textarea.innerHTML = currentText.substring(0, index - 1) + currentText.substring(index + currentItem.length);
        }
    })
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