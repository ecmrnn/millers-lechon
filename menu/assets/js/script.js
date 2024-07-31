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

// copy text button event
const copyBtn = document.querySelector("#copy");
copyBtn.addEventListener('click', () => {
    textarea.select();
    textarea.setSelectionRange(0, 99999); /* For mobile devices */
  
    navigator.clipboard.writeText(textarea.innerHTML);
})

// reset text button
const resetBtn = document.querySelector("#reset");
resetBtn.addEventListener('click', e => {
    e.preventDefault();
    
    if (confirm("Sureball?")) {
        let inputs = document.querySelectorAll("input");

        inputs.forEach(input => {
            input.checked = false;
        });
        textarea.innerHTML = `Available na ulam for today! 💖 - ${today}\n\n`;
    } 
})
