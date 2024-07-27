let months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
];

let today = new Date();
today = `${months[today.getMonth()]} ${today.getDate()}, ${today.getFullYear()}`;

const textarea = document.querySelector("#output");
textarea.innerHTML = `Available na ulam for today! 💖 - ${today}\n\n`;

// ulam events
let ulams = document.querySelectorAll("input");
ulams.forEach(ulam => {
    ulam.addEventListener('change', () => {
        let name = ulam.nextElementSibling.children[0].innerHTML;
        let price = ulam.nextElementSibling.children[1].innerHTML;
        let currentText = textarea.innerHTML;

        if (ulam.checked) {
            textarea.innerHTML = "";
            textarea.innerHTML = currentText + `- ${name} : ${price}\n`;
        } else {
            let currentItem = `- ${name} : ${price}`;
            let index = textarea.innerHTML.indexOf(currentItem);

            textarea.innerHTML = '';
            textarea.innerHTML = currentText.substring(0, index - 1) + currentText.substring(index + currentItem.length);
        }
    })
});

// copy text button event
const copyBtn = document.querySelector("#copy");
copyBtn.addEventListener('click', () => {
    textarea.select();
    textarea.setSelectionRange(0, 99999); /* For mobile devices */
  
    navigator.clipboard.writeText(textarea.innerHTML);
})