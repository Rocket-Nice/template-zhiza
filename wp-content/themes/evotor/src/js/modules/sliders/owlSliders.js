import 'owl.carousel';

$('.owl-slider').owlCarousel({
  items: 3,
  margin: 24,
  //dotsEach: true,
  autoWidth: true,
  loop: true,
  navText: [
    '<div class="arrow-wrapper"><img src="/wp-content/themes/evotor/assets/images/circle_orange_arrow.svg" alt="" loading="lazy" decoding="async"/></div>',
    '<div class="arrow-wrapper"><img src="/wp-content/themes/evotor/assets/images/circle_orange_arrow.svg" alt="" loading="lazy" decoding="async"/></div>',
  ],
  responsive: {
    0: {
      items: 2,
      nav: false,
      mouseDrag: true,
      dots: true,
      autoHeight: true,
    },
    768: {
      items: 2,
      stagePadding: 62,
      nav: false,
    },
    992: {
      items: 3,
      nav: false,
    },
    1200: {
      items: 3,
      nav: true,
      mouseDrag: false,
      dots: false,
    },
  },
});

$('.togetherSlider').owlCarousel({
  items: 2,
  navText: [
    '<img src="/wp-content/themes/evotor/assets/images/circle_orange_arrow.svg" alt="" loading="lazy" decoding="async"/>',
    '<img src="/wp-content/themes/evotor/assets/images/circle_orange_arrow.svg" alt="" loading="lazy" decoding="async"/>',
  ],
  stagePadding: 62,
  margin: 60,
  nav: true,
  mouseDrag: false,
  dots: false,
  responsive: {
    0: {
      items: 1,
      nav: false,
      mouseDrag: true,
      margin: 30,
      dots: true,
    },
    768: {
      items: 2,
      stagePadding: 62,
      dots: true,
      mouseDrag: true,
      margin: 30,
      nav: false,
    },
    992: {
      items: 2,
      nav: false,
      dots: true,
      margin: 30,
      mouseDrag: true,
    },
    1032: {
      items: 2,
      nav: false,
      mouseDrag: true,
      dots: true,
    },
    1199: {
      items: 2,
      nav: true,
      mouseDrag: false,
      dots: false,
    }
  }
})
