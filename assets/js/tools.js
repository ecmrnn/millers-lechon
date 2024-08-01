// Add tool here...
const tools = [
    // [0] Link
    // [1] Icon
    // [2] Name
    // [3] Description
    ["table", "table_restaurant", "Table Manager", "To manage the restaurant's table."],
    ["menu", "menu_book", "Menu Generator", "To generate text menu for Facebook posts."],
];

let output = document.querySelector("#tools");

const showTool = (tool) => {
    console.log("Hello world");
    let a = document.createElement("a");
    let iconWrapper = document.createElement("div");
    let icon = document.createElement("span");
    let descWrapper = document.createElement("div");
    let h2 = document.createElement("h2");
    let p = document.createElement("p");

    // Anchor
    aClass = "block border rounded-md p-3 gap-3 items-start hover:shadow-xl transition-all ease-in-out group".split(' ');
    a.setAttribute("href", `${tool[0]}/index.html`);
    a.classList.add(...aClass);

    // Icon
    iconWrapperClass = "grid place-items-center p-3 border rounded-md aspect-square w-min group-hover:border-transparent group-hover:bg-green-500 group-hover:text-white transition-all ease-in-out".split(' ');
    iconWrapper.classList.add(...iconWrapperClass);
    icon.classList.add("material-symbols-outlined");
    icon.innerHTML = tool[1];
    iconWrapper.appendChild(icon);

    // Description
    descWrapper.classList.add("mt-5");
    h2.classList.add("font-bold");
    h2.innerHTML = tool[2];
    p.classList.add("text-sm");
    p.innerHTML = tool[3];
    descWrapper.appendChild(h2);
    descWrapper.appendChild(p);

    // Output
    a.appendChild(iconWrapper);
    a.appendChild(descWrapper);
    output.appendChild(a);
}

tools.forEach(tool => {
    showTool(tool);
});