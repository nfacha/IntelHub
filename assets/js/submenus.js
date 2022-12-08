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

// // Get the mobile menu toggle button
// const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
//
// // Add a click event listener to the mobile menu toggle button
// mobileMenuToggle.addEventListener('click', () => {
//     // Get the mobile menu
//     const mobileMenu = document.querySelector('.mobile-menu');
//
//     // If the mobile menu is already open, close it
//     if (mobileMenu.classList.contains('open')) {
//         mobileMenu.classList.remove('open');
//     } else { // Otherwise, open the mobile menu
//         mobileMenu.classList.add('open');
//     }
// });