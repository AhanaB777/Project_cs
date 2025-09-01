document.addEventListener("DOMContentLoaded", function () {
    let sidebar = document.querySelector(".sidebar");
    let toggleButton = document.querySelector(".menu-toggle");

    toggleButton.addEventListener("click", function () {
        sidebar.classList.toggle("open");
    });
});
