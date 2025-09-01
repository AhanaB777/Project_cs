document.addEventListener("DOMContentLoaded", function () {
    // Toggle Filter Section
    let filterToggle = document.getElementById("filter-toggle");
    let filterSection = document.getElementById("filter-section");

    if (filterToggle) {
        filterToggle.addEventListener("click", function () {
            if (filterSection.style.display === "block") {
                filterSection.style.display = "none";
            } else {
                filterSection.style.display = "block";
            }
        });
    }

    // Confirmation Pop-ups
    let deleteLinks = document.querySelectorAll(".delete");
    deleteLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            let confirmDelete = confirm("Are you sure you want to delete this notice?");
            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });

    let restoreLinks = document.querySelectorAll(".restore");
    restoreLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            let confirmRestore = confirm("Restore this notice?");
            if (!confirmRestore) {
                event.preventDefault();
            }
        });
    });
});
