// Get the current page URL
var url = window.location.href;

// Get all the links in the navigation menu
var links = document.querySelectorAll('.first-list li a');

// Loop through the links and add the active class to the link that corresponds to the current page
for (var i = 0; i < links.length; i++) {
  if (links[i].href === url) {
    links[i].classList.add('active');
    break;
  }
}