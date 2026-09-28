const body = document.body;
localStorage.setItem('theme', 'light');
const theme = localStorage.getItem('theme')

if (theme) 
  document.documentElement.setAttribute('data-bs-theme', theme);
