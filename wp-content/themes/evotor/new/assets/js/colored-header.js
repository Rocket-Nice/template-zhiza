const coloredHeader = () => {
  const windowScrollToTop = $(window).scrollTop()
  const title = $('.js-article-title')
  const header = $('.header--colored')
  const headerData = header.data()
  const titleOffsetTop = title.offset().top
  const isGradient = titleOffsetTop < 770

  if (isGradient) {
    title.addClass('header__title--colored')
  } else {
    title.removeClass('header__title--colored')
  }
 
  if (headerData.color) {
    header.css('background-color', headerData.color)
  }
}

$(document).ready(function() {
  coloredHeader()
});

$(window).scroll(function(e) {
  coloredHeader()
});
