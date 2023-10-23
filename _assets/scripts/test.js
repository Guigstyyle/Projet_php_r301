function createParagraph() {
    let para = document.createElement("p");
    para.textContent = "Vous avez cliqué !";
    document.body.appendChild(para);
}

let clickableTitles = document.getElementsByTagName("h1");

for (let i = 0; i < clickableTitles.length; i++) {
    clickableTitles[i].addEventListener("click", createParagraph);
}