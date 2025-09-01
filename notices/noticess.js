document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("filter-toggle");
    const filterSection = document.getElementById("filter-section");
  
    toggleBtn.addEventListener("click", () => {
      filterSection.style.display =
        filterSection.style.display === "block" ? "none" : "block";
    });
  });
  