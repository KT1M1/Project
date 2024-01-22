// Back to top
var amountScrolled = 200;

window.addEventListener('scroll', function () {
  var backToTopButton = document.querySelector('.back-to-top');

  if (window.pageYOffset > amountScrolled) {
    backToTopButton.classList.add('show');
  } else {
    backToTopButton.classList.remove('show');
  }
});

document.querySelector('.back-to-top').addEventListener('click', function () {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});
