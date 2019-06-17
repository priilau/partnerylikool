console.log("main.js initialized");

// site/index.php
window.onscroll = function() { scrollHeader(); }

let header = document.getElementById("header-menu");
let sticky = header.offsetTop;

function scrollHeader() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}