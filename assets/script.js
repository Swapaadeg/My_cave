//Menu
document.addEventListener('DOMContentLoaded', () => {
  const burger = document.querySelector('.burger');
  const navbar = document.querySelector('.navbar');

  if (burger) {
    burger.addEventListener('click', () => {
      navbar.classList.toggle('open');
    });
  }
});


// MODALE FLASH

function fermerModale() {
      const modale = document.getElementById('modale-flash');
      if (modale) {
          modale.style.display = 'none';
      }
  }

  // Fermer automatiquement après 2 secondes
  setTimeout(() => {
      fermerModale();
  }, 2000);

// Bouton scroll top
const scrollBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', function() {
  if (window.scrollY > 200) {
      scrollBtn.style.display = 'flex';
  } else {
      scrollBtn.style.display = 'none';
  }
});
scrollBtn.addEventListener('click', function() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});