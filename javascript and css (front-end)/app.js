const navToggle = document.querySelector(".nav-toggle");

const links = document.querySelector(".links");



navToggle.addEventListener("click", function () {

links.classList.toggle("show-links");

});

function updateTextInput(val) {

document.getElementById('price_text').value=val;

};