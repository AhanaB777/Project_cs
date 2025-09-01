document.addEventListener("DOMContentLoaded", function () {
    let slider = document.querySelector(".book-slider");
    let leftBtn = document.querySelector(".left-btn");
    let rightBtn = document.querySelector(".right-btn");

    leftBtn.addEventListener("click", function () {
        slider.scrollBy({ left: -300, behavior: "smooth" });
    });

    rightBtn.addEventListener("click", function () {
        slider.scrollBy({ left: 300, behavior: "smooth" });
    });
});


