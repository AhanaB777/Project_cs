const hamburger = document.getElementById('hamburger-btn');
const header = document.getElementById('main-header');
const overlay = document.getElementById('nav-overlay');

hamburger.addEventListener('click', () => {
  header.classList.toggle('active');
  overlay.classList.toggle('hidden');
  hamburger.classList.toggle('active');
});

overlay.addEventListener('click', () => {
  header.classList.remove('active');
  overlay.classList.add('hidden');
  hamburger.classList.remove('active');
});
