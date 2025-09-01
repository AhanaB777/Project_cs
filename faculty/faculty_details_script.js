// Select elements
const facultySlider = document.querySelector(".faculty-slider");
const leftBtn = document.querySelector(".left-btn");
const rightBtn = document.querySelector(".right-btn");

// Scroll amount per click
const scrollStep = 370; // Adjusted for new card size

// Move slider left
leftBtn.addEventListener("click", () => {
    facultySlider.scrollLeft -= scrollStep;
});

// Move slider right
rightBtn.addEventListener("click", () => {
    facultySlider.scrollLeft += scrollStep;
});

// Computer Science Faculty Data
const faculties = [
    { "name": "Mr. DIPAK KUMAR SARKAR", "department": "Computer Science", "designation": "State Aided College Teacher, HoD", "qualification": "MCA", "specialization": "Development & Testing of Online Share Trading System", "photo": "images/dipak_kumar_sarkar.jpg" },
    { "name": "Mr. PREM KUMAR JHA", "department": "Computer Science", "designation": "State Aided College Teacher", "qualification": "M.Sc.", "specialization": "Compiler Construct", "photo": "images/prem_kumar_jha.jpg" },
    { "name": "Mrs. PRIYANKA CHATTERJEE", "department": "Computer Science", "designation": "State Aided College Teacher", "qualification": "M.Sc.", "specialization": "Windows Based GIS", "photo": "images/priyanka_chatterjee.jpg" },
    { "name": "Mr. SHIBAJI KUNDU", "department": "Computer Science", "designation": "State Aided College Teacher", "qualification": "M.Sc.", "specialization": "Cryptography", "photo": "images/shibaji_kundu.jpg" },
    { "name": "Mr. ARNOB SUR", "department": "Computer Science", "designation": "State Aided College Teacher", "qualification": "M.Sc.", "specialization": "Image Processing, Artificial Intelligence", "photo": "images/arnob_sur.jpg" }
];

// Generate Faculty Cards
faculties.forEach(faculty => {
    let card = document.createElement("div");
    card.classList.add("faculty-card");
    card.innerHTML = `
        <img src="${faculty.photo}" alt="${faculty.name}">
        <h3>${faculty.name}</h3>
        <p class="label">Department:</p>
        <p>${faculty.department}</p>
        <p class="label">Designation:</p>
        <p>${faculty.designation}</p>
        <p class="label">Qualification:</p>
        <p>${faculty.qualification}</p>
        <p class="label">Specialization:</p>
        <p>${faculty.specialization}</p>
    `;

    facultySlider.appendChild(card);
});


