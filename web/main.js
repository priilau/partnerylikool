console.log("main.js initialized");

// site/index.php
window.onscroll = function() { ScrollHeader(); }

let header = document.getElementById("header-menu");
let sticky = header.offsetTop;

function ScrollHeader() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}