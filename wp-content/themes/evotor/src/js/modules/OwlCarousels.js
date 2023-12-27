/**
 * Инициализация OwlCarousel слайдеров
 */
export default function initCarousels() {
  $('.tests_carousel').owlCarousel({
    items: 4,
    nav: true,
    dots: true,
    loop: true,
    margin: 20,
    navText: [
      '<img src="/wp-content/themes/evotor/images/main_page/prev_white.svg" alt="" width="16" height="42">',
      '<img src="/wp-content/themes/evotor/images/main_page/next_white.svg" alt="" width="16" height="42">'
    ],
    autoplay: false,
    responsive: {
      0: {
        items: 1,
        navText: ['', ''],
        margin: 3,
        stagePadding: 20,
      },
      1200: {
        items: 4,
      }
    }
  });

  $('.n_video_carousel').owlCarousel({
    items: 1,
    nav: true,
    dots: true,
    loop: false,
    navText: [
      '<img src="/wp-content/themes/evotor/images/main_page/prev_white.svg" alt="" width="16" height="42">',
      '<img src="/wp-content/themes/evotor/images/main_page/next_white.svg" alt="" width="16" height="42">'
    ],
    autoplay: false,
    responsive: {
      0: {
        items: 1,
        margin: 3,
        stagePadding: 20,
      },
      1200: {
        items: 1,
      }
    }
  });

  $('.fond_carousel').owlCarousel({
    items: 3,
    nav: true,
    dots: true,
    loop: true,
    margin: 20,
    navText: [
      '<img src="/wp-content/themes/evotor/images/main_page/prev_black.svg" alt="" width="16" height="42">',
      '<img src="/wp-content/themes/evotor/images/main_page/next_black.svg" alt="" width="16" height="42">'
    ],
    autoplay: false,
    responsive: {
      0: {
        items: 2,
        navText: ['', ''],
        margin: 3,
        stagePadding: 20,
      },
      1200: {
        items: 3,
      }
    }
  });

  $('.bot_carousel').owlCarousel({
    items: 4,
    nav: true,
    autoWidth: false,
    dots: true,
    loop: true,
    margin: 20,
    navText: [
      '<img src="/wp-content/themes/evotor/images/main_page/prev_black.svg" alt="" width="16" height="42">',
      '<img src="/wp-content/themes/evotor/images/main_page/next_black.svg" alt="" width="16" height="42">'
    ],
    autoplay: false,
    responsive: {
      0: {
        items: 1,
        navText: ['', ''],
        margin: 3,
        autoWidth: false,
        stagePadding: 20,
      },
      1200: {
        items: 4,
      }
    }
  });

  $('.n_podbor_carousel').owlCarousel({
    items: 4,
    nav: true,
    dots: true,
    loop: true,
    margin: 20,
    navText: [
      '<img src="/wp-content/themes/evotor/images/main_page/prev_black.svg" alt="" width="16" height="42">',
      '<img src="/wp-content/themes/evotor/images/main_page/next_black.svg" alt="" width="16" height="42">'
    ],
    autoplay: false,
    responsive: {
      0: {
        items: 2,
        navText: ['', ''],
        margin: 3,
        nav: true,
        stagePadding: 20,
      },
      1200: {
        items: 4,
        nav: true,
      }
    }
  });

  $('.n_podbor_carousel_page').owlCarousel({
    items: 4,
    nav: true,
    dots: true,
    loop: false,
    margin: 20,
    navText: [
      '<img src="/wp-content/themes/evotor/images/main_page/prev_orange.svg" alt="" width="16" height="42">',
      '<img src="/wp-content/themes/evotor/images/main_page/next_orange.svg" alt="" width="16" height="42">'
    ],
    autoplay: false,
    responsive: {
      0: {
        items: 2,
        navText: ['', ''],
        margin: 3,
        autoWidth: false,
        stagePadding: 20,
      },
      1200: {
        items: 4,
      }
    }
  });

  /**
   * TODO: подкасты
   * Подкасты временно отключены.
   */
  // $('.other_podcast_carousel').owlCarousel({
  //   nav: false,
  //   dots: false,
  //   loop: false,
  //   autoplay: false,
  //   responsive: {
  //     0: {
  //       items: 1,
  //       margin: 8,
  //       stagePadding: 20,
  //       mouseDrag: true,
  //     },
  //     1200: {
  //       items: 2,
  //       margin: 18,
  //       mouseDrag: false,
  //     }
  //   }
  //
  //
  // });
}
