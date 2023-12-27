import '../scss/style.scss';
//
const $ = require("jquery");
window.jQuery = $;
window.$ = window.jQuery = $;
import '@fancyapps/fancybox';
//
require('./modules/SearchPanel');
// import './jquery.jplayer.js'; // TODO пока отключены подкасты, и модуль этот не требуется.
import './owl.carousel.min.js';
import './likely.js';
import './loadmore.js';
import './work.js';
import './modules/YoutubeFrame.js';
import './modules/CookieBanner.js';
//
import initCarousels from "./modules/OwlCarousels";
import {RedesignedSubscribeForm} from "./modules/RedesignedSubscribeForm";
import toTopScrollButton from './modules/toTopScrollButton';

const HEADER_HEIGHT = 80;

document.addEventListener('DOMContentLoaded', function () {
  // Показ модального окна подписки только для новых пользователей.
  const storageKey = 'notShowSubscribeModal';
  if (!localStorage.getItem(storageKey)) {
    setTimeout(function () {
      $('#my_modal_subs_btn').click()
    }, 20000);

    localStorage.setItem(storageKey, 'true');
  }
  //
  initCarousels();

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
          }
        });
      }
    });
  }

  function scrollTo(element) {
    console.log('offset', element.offsetTop - HEADER_HEIGHT);
    window.scroll({
      behavior: 'smooth',
      left: 0,
      top: element.offsetTop + HEADER_HEIGHT,
    });
  }

  RedesignedSubscribeForm();
  //
  toTopScrollButton();
});
