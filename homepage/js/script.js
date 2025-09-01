document.addEventListener("DOMContentLoaded", function() {
    // Smooth Fade-in Animation for Elements
    document.querySelectorAll('.fade-in').forEach(element => {
        element.style.opacity = '0';
        element.style.transition = 'opacity 1.5s ease-in-out';
        setTimeout(() => {
            element.style.opacity = '1';
        }, 300);
    });

    // Navbar Animation
    let navLinks = document.querySelectorAll(".top-nav a");
    navLinks.forEach((link, index) => {
        link.style.opacity = "0";
        link.style.transform = "translateY(-10px)";
        setTimeout(() => {
            link.style.opacity = "1";
            link.style.transform = "translateY(0)";
        }, index * 150);
    });
});
