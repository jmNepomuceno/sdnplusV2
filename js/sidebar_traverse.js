const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggle-btn');
const main = document.querySelector('.main');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('closed');
    main.classList.toggle('full');
});
