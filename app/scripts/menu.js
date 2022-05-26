document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.menu-toggle');
  const content = document.querySelector('.content');
  const menu = document.querySelector('.menu');

  toggle.onclick = () => {
    menu.classList.toggle('hidden');
    content.classList.toggle('no-menu');
  };
});
