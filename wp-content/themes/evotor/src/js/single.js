import '../scss/single.scss';
import Swiper from 'swiper/bundle';
import SliderReadMore from './modules/sliders/readMoreSlider';
import {ContentTable} from "./modules/ContentTable";
import {Accord, CloseAccords} from "./modules/Accord";
import CountsComment from "./modules/CountsComment";

document.addEventListener('DOMContentLoaded', function () {
  console.log('single');
  SliderReadMore();
  CountsComment();
  console.log('single');
  SliderReadMore();

  const swiperContainers = document.querySelectorAll('.__carousel .swiper');
  const prevButtons = document.querySelectorAll('.__carousel .swiper-button-prev');
  const nextButtons = document.querySelectorAll('.__carousel .swiper-button-next');

  swiperContainers.forEach((swiperContainer, index) => {
    const prevButton = prevButtons[index];
    const nextButton = nextButtons[index];

    const mySwiper = new Swiper(swiperContainer, {
      direction: 'horizontal',
      slidesPerView: 1,

      breakpoints: {
        1201: {
          navigation: {
            prevEl: prevButton ? prevButton : '',
            nextEl: nextButton ? nextButton : '',
          },
        },
        0: {
          navigation: {
            prevEl: '',
            nextEl: '',
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
        },
      },
    });
  });

  const HEADER_HEIGHT = 120;

  const allLinks = document.querySelectorAll('a[href*="#"]');
  if (allLinks) {
    Array.prototype.slice.call(allLinks).forEach((el) => {
      const href = el.href;
      if (/#\d+$/.test(href)) {
        console.log(href);
        el.addEventListener('click', (e) => {
          e.preventDefault();
          const target = e.currentTarget;
          const name = el.getAttribute('href').substr(1);
          const element = document.getElementsByName(name);
          if (element.length) {
            console.log('length > 0', element[0]);
            scrollTo(element[0]);
            CloseAccords();
          }
        });
      }
    });
  }

  function scrollTo(element) {
    // console.log('offset', element.offsetTop - HEADER_HEIGHT);
    console.log('offset', element.getBoundingClientRect().top + window.scrollY - HEADER_HEIGHT);
    window.scroll({
      behavior: 'smooth',
      left: 0,
      top: element.getBoundingClientRect().top + window.scrollY - HEADER_HEIGHT,
    });
  }

  // Скользяжий блок оглавление в single страницах
  ContentTable();
  Accord();
});
