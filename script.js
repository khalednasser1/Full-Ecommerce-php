
let topBtn = document.getElementById("backToTop");

window.onscroll = function() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        topBtn.style.display = "block";
    } else {
        topBtn.style.display = "none";
    }
};

topBtn.onclick = function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
};