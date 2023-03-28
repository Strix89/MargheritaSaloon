const slider = document.querySelector('.slider-container');
const slides = document.querySelectorAll('.slide');
const prev = document.querySelector('.slider-prev');
const next = document.querySelector('.slider-next');
let slideIndex = 0;

// funzione per mostrare solo la slide corrente
function showSlide() {
  for (let i = 0; i < slides.length; i++) {
    slides[i].classList.remove('active');
  }
  slides[slideIndex].classList.add('active');
}

// funzione per passare alla slide successiva
function nextSlide() {
  slideIndex++;
  if (slideIndex >= slides.length) {
    slideIndex = 0;
  }
  showSlide();
}

// funzione per passare alla slide precedente
function prevSlide() {
  slideIndex--;
  if (slideIndex < 0) {
    slideIndex = slides.length - 1;
  }
  showSlide();
}

// event listener per il click sulla freccia destra
next.addEventListener('click', function() {
  nextSlide();
});

// event listener per il click sulla freccia sinistra
prev.addEventListener('click', function() {
  prevSlide();
});

// mostrare la prima slide all'avvio
showSlide();
