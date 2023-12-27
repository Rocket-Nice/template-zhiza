import 'owl.carousel';

const carouselOptions = {
  items: 4,
  margin: 24,
  autoWidth: true,
  dots: false,
  slideBy: 'page',
  loop:true,
  navText: [
    '<div class="arrow-wrapper"><img src="/wp-content/themes/evotor/assets/images/orange_arrow.svg" alt="" loading="lazy" decoding="async"/></div>',
    '<div class="arrow-wrapper"><img src="/wp-content/themes/evotor/assets/images/orange_arrow.svg" alt="" loading="lazy" decoding="async"/></div>',
  ],
  responsive: {
    1280: {
      items: 1,
      rows: 2,
      nav: true,
      dots: false,
    },
    0: {
      items: 2,
      rows: 1,
      dots: true,
      nav: false,
      stagePadding: 62,
      margin: 16,
    }
  }
};
let carousel;
const el = $('#top-posts-owl-carousel');

//Taken from Owl Carousel, so we calculate width the same way
const viewport = function() {
  let width;
  if (carouselOptions.responsiveBaseElement && carouselOptions.responsiveBaseElement !== window) {
    width = $(carouselOptions.responsiveBaseElement).width();
  } else if (window.innerWidth) {
    width = window.innerWidth;
  } else if (document.documentElement && document.documentElement.clientWidth) {
    width = document.documentElement.clientWidth;
  } else {
    console.warn('Can not detect viewport width.');
  }
  return width;
};

let severalRows = false;
let orderedBreakpoints = [];
for (let breakpoint in carouselOptions.responsive) {
  if (carouselOptions.responsive[breakpoint].rows > 1) {
    severalRows = true;
  }
  orderedBreakpoints.push(parseInt(breakpoint));
}

//Custom logic is active if carousel is set up to have more than one row for some given window width
if (severalRows) {
  orderedBreakpoints.sort(function (a, b) {
    return b - a;
  });
  let slides = el.find('[data-slide-index]');
  let slidesNb = slides.length;
  if (slidesNb > 0) {
    let rowsNb;
    let previousRowsNb = undefined;
    let colsNb;
    let previousColsNb = undefined;

    //Calculates number of rows and cols based on current window width
    let updateRowsColsNb = function () {
      let width =  viewport();
      for (let i = 0; i < orderedBreakpoints.length; i++) {
        let breakpoint = orderedBreakpoints[i];
        if (width >= breakpoint || i === (orderedBreakpoints.length - 1)) {
          let breakpointSettings = carouselOptions.responsive['' + breakpoint];
          rowsNb = breakpointSettings.rows;
          colsNb = breakpointSettings.items;
          break;
        }
      }
    };

    let updateCarousel = function () {
      updateRowsColsNb();

      //Carousel is recalculated if and only if a change in number of columns/rows is requested
      if (rowsNb !== previousRowsNb || colsNb !== previousColsNb) {
        let reInit = false;
        if (carousel) {
          //Destroy existing carousel if any, and set html markup back to its initial state
          carousel.trigger('destroy.owl.carousel');
          carousel = undefined;
          slides = el.find('[data-slide-index]').detach().appendTo(el);
          el.find('.fake-col-wrapper').remove();
          reInit = true;
        }


        //This is the only real 'smart' part of the algorithm

        //First calculate the number of needed columns for the whole carousel
        let perPage = rowsNb * colsNb;
        let pageIndex = Math.floor(slidesNb / perPage);
        let fakeColsNb = pageIndex * colsNb + (slidesNb >= (pageIndex * perPage + colsNb) ? colsNb : (slidesNb % colsNb));

        //Then populate with needed html markup
        let count = 0;
        for (let i = 0; i < fakeColsNb; i++) {
          //For each column, create a new wrapper div
          let fakeCol = $('<div class="fake-col-wrapper"></div>').appendTo(el);
          for (let j = 0; j < rowsNb; j++) {
            //For each row in said column, calculate which slide should be present
            let index = Math.floor(count / perPage) * perPage + (i % colsNb) + j * colsNb;
            if (index < slidesNb) {
              //If said slide exists, move it under wrapper div
              slides.filter('[data-slide-index=' + index + ']').detach().appendTo(fakeCol);
            }
            count++;
          }
        }
        //end of 'smart' part

        previousRowsNb = rowsNb;
        previousColsNb = colsNb;

        if (reInit) {
          //re-init carousel with new markup
          carousel = el.owlCarousel(carouselOptions);
        }
      }
    };

    //Trigger possible update when window size changes
    $(window).on('resize', updateCarousel);

    //We need to execute the algorithm once before first init in any case
    updateCarousel();
  }
}

//init
carousel = el.owlCarousel(carouselOptions);
