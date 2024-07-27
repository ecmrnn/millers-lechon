let ulam = [
    ["Sinigang (Baboy)", 120.00],
    ["Lechon Sisig", 120.00],
    ["Dinuguan", 80.00],
    ["Chopsuey", 60.00],
    ["Ampalaya", 50.00],
];

let output = document.querySelector("#ulams");

ulam.forEach(u => {
    let label = document.createElement("label");
    let input = document.createElement("input");
    let p = document.createElement("p");

    label.setAttribute("for", u[0]);
    label.classList.add("ulam-label");
    label.classList.add("select-none");
    label.classList.add("flex");
    label.classList.add("items-center");
    label.classList.add("gap-5");

    input.setAttribute("type", "checkbox");
    input.setAttribute("id", u[0]);

    p.classList.add("capitalize");
    p.innerHTML = `<strong>${u[0]}</strong> - <span>${u[1]}</span>`;

    label.appendChild(input)
    label.appendChild(p)

    output.appendChild(label)
    console.log(output)
});
{/* <label for="<?= $ulam["ulam"] ?>" class="">
    <input type="checkbox" name="ulam" id="<?= $ulam["ulam"] ?>">
    <p class="capitalize"><strong class="ulam-name"><?= $ulam["ulam"] ?></strong> - <span><?= number_format($ulam["price"], 2) ?></span></p>
</label> */}