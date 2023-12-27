
$(".header .burger").on('click', function(e) {
  e.preventDefault();

  $(".header nav").toggleClass('active');
  $(this).toggleClass('active');

  $('body').toggleClass('no-scroll');
});
