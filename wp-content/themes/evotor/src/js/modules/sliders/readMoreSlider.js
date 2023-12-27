import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';

export default function SliderReadMore() {
  const swiperContainer = document.querySelector('.__fourth-slide .swiper');
  const threeSlideSwiperContainer = document.querySelector('.__three-slide .swiper');
  const wrapperContainer = document.querySelector('.n_podbor_page .wrapper');
  let mySwiper;

  if (swiperContainer || threeSlideSwiperContainer) {
    const prevButton = wrapperContainer.querySelector('.swiper-button-prev');
    const nextButton = wrapperContainer.querySelector('.swiper-button-next');
    let targetClass = !threeSlideSwiperContainer ? swiperContainer : threeSlideSwiperContainer;
    let slidesPerViewValue = targetClass === swiperContainer ? 'auto' : 3;

    mySwiper = new Swiper(targetClass, {
      modules: [Pagination],
      direction: 'horizontal',
      slidesPerView: slidesPerViewValue,
      cssMode: true,
      breakpoints: {
        1201: {
          spaceBetween: 24,
          navigation: {
            prevEl: prevButton ? prevButton : '',
            nextEl: nextButton ? nextButton : '',
            lockClass: 'swiper-button-lock',
          },
        },
        576: {
          spaceBetween: 16,
          navigation: false,
          slidesPerView: "auto",
          pagination: {
            el: '.swiper-pagination',
            type: "bullets",
            clickable: true,
          },
        },
        0: {
          slidesPerView: 'auto',
          navigation: false,
          spaceBetween: 8,
          pagination: {
            el: '.swiper-pagination',
            type: "bullets",
            clickable: true,
          },
        },
      },
    });
  }
  return mySwiper;
}
