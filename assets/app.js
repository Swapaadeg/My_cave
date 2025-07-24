/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import Choices from 'choices.js';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

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


// MODALE 

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