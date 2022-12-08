// Get all the menu links with submenus
const menuLinks = document.querySelectorAll('.menu-link');

// Add a click event listener to each menu link
menuLinks.forEach((menuLink) => {
    menuLink.addEventListener('click', (event) => {
        // Prevent the default link behavior
        event.preventDefault();

        // Get the submenu associated with this menu link
        const submenu = menuLink.nextElementSibling;

        // If the submenu is already open, close it
        if (submenu.classList.contains('open')) {
            submenu.classList.remove('open');
            submenu.classList.add('hidden');
        } else { // Otherwise, open the submenu
            submenu.classList.add('open');
            submenu.classList.remove('hidden');
        }
    });
});