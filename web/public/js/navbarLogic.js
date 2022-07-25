function addNavbarMoving() {
    if (window.innerWidth <= 992) {
        let menu = document.querySelector('.navbar-toggler');
        let menuBox = document.querySelector('.navbar-collapse');
        let menuBoxItems = document.querySelectorAll('.nav-link');
        
        menuBoxItems.forEach(current => {
            current.onclick = () => {
                menuBox.classList.remove('show');
                document.body.classList.remove('overflow-hidden');
                menu.classList.toggle('_active');
            }
        });
        
        menu.onclick = menuOpen;
        
        function menuOpen(e) {
                menu.disabled = true;
                menuBox.ontransitionend = () => {
                    menu.disabled = false;
                }
            
                e.preventDefault();
                document.body.classList.toggle('overflow-hidden');
                menu.classList.toggle('_active');
            }
        
    }
}
addNavbarMoving();

// add resize event
window.addEventListener('resize' , addNavbarMoving);