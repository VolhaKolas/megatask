$(".search").on("submit", function (event) {
    event.preventDefault();
});

$(".search input").on("keyup", function () {
    var text = this.value.toLowerCase();
    var trs = document.querySelectorAll(".searched");
    for(var i = 0; i < trs.length; i++) {
        var innerText = trs[i].children[0].innerText + " " +  trs[i].children[1].innerText + " " +  trs[i].children[2].innerText;
        innerText = innerText.toLowerCase();
        if(-1 == innerText.indexOf(text, 0)) {
            trs[i].style.display = "none";
        }
        else {
            trs[i].style.display = "";
        }
    }
});


$(".searchcourse").on("submit", function (event) {
    event.preventDefault();
});

$(".searchcourse input").on("keyup", function () {
    var text = this.value.toLowerCase();
    var trs = document.querySelectorAll(".searchedcourse");
    for(var i = 0; i < trs.length; i++) {
        var innerText = trs[i].children[0].innerText;
        innerText = innerText.toLowerCase();
        if(-1 == innerText.indexOf(text, 0)) {
            trs[i].style.display = "none";
        }
        else {
            trs[i].style.display = "";
        }
    }
});