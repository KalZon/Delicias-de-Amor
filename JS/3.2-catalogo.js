const mostrar_dulces = document.getElementById('mostrar_dulces');
const mostrar_postres = document.getElementById('mostrar_postres');
const mostrar_empanadas = document.getElementById('mostrar_empanadas');
const mostrar_bocaditos = document.getElementById('mostrar_bocaditos');

const postres = document.querySelectorAll('#postres');
const dulces = document.querySelectorAll('#dulces');
const empanadas = document.querySelectorAll('#empanadas');
const bocaditos = document.querySelectorAll('#bocaditos');

mostrar_dulces.addEventListener('click', () => {
  postres.forEach(elemento => elemento.style.display = 'none');
  empanadas.forEach(elemento => elemento.style.display = 'none');
  bocaditos.forEach(elemento => elemento.style.display = 'none');
  dulces.forEach(elemento => elemento.style.display = 'inline-block');
  event.preventDefault();
});

mostrar_postres.addEventListener('click', () => {
  dulces.forEach(elemento => elemento.style.display = 'none');
  empanadas.forEach(elemento => elemento.style.display = 'none');
  bocaditos.forEach(elemento => elemento.style.display = 'none');
  postres.forEach(elemento => elemento.style.display = 'inline-block');
  event.preventDefault();
});

mostrar_empanadas.addEventListener('click', () => {
  dulces.forEach(elemento => elemento.style.display = 'none');
  postres.forEach(elemento => elemento.style.display = 'none');
  bocaditos.forEach(elemento => elemento.style.display = 'none');
  empanadas.forEach(elemento => elemento.style.display = 'inline-block');
  event.preventDefault();
});

mostrar_bocaditos.addEventListener('click', () => {
  dulces.forEach(elemento => elemento.style.display = 'none');
  postres.forEach(elemento => elemento.style.display = 'none');
  empanadas.forEach(elemento => elemento.style.display = 'none');
  bocaditos.forEach(elemento => elemento.style.display = 'inline-block');
  event.preventDefault();
});

mostrar_TODO.addEventListener('click', () => {
    dulces.forEach(elemento => elemento.style.display = 'inline-block');
    postres.forEach(elemento => elemento.style.display = 'inline-block');
    empanadas.forEach(elemento => elemento.style.display = 'inline-block');
    bocaditos.forEach(elemento => elemento.style.display = 'inline-block');
    event.preventDefault();
  });