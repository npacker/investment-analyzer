document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.menu-toggle');
  const menu = document.querySelector('.menu');

  toggle.onclick = () => {
    menu.classList.toggle('hidden');
  };
});
