const $ = require("jquery");
window.jQuery = $;
window.$ = window.jQuery = $;

import '@fancyapps/fancybox';
//
import '../scss/redesign.scss';
import './modules/CookieBanner.js';
import './modules/subscribe/subscribe-forms.js';
import './modules/sliders/owlSliders.js';
import './modules/sliders/twoRowTopPosts.js';
import './modules/SearchPanel.js';
import './modules/CollectionsGridLayout';
import './modules/AuthorPostPostPaginator';
import './modules/SearchPage';
import './likely.js';

import { RedesignedSubscribeForm } from "./modules/RedesignedSubscribeForm";
import { RandomCollectionOnMainPage } from './modules/RandomCollectionOnMainPage';
import toTopScrollButton from "./modules/toTopScrollButton";

document.addEventListener('DOMContentLoaded', function () {
  const body = document.querySelector('body');

  /**
   * Обработка открытия навигационного меню на мобильной версии.
   */
  const hamburger = document.querySelector('#menu_btn');
  const closeMenu = document.querySelector('#close_mobile_menu');
  const menu = document.querySelector('#m_menu');
  //
  hamburger.addEventListener('click', (e) => {
    menu.classList.toggle('open');
    body.classList.toggle('menu--open');
  });

  closeMenu.addEventListener('click', (e) => {
    menu.classList.toggle('open');
    body.classList.toggle('menu--open');
  });

  /**
   * Показ модального окна подписки 1 раз для новых пользователей, кто ещё не был на сайте.
   */
  const storageKey = 'notShowSubscribeModal';
  if (!localStorage.getItem(storageKey)) {
    setTimeout(function () {
      $('#my_modal_subs_btn').trigger('click');
    }, 20000);

    localStorage.setItem(storageKey, 'true');
  }

  RedesignedSubscribeForm();

  function gotoLinkAnyPlaceInCard(e) {
    const target = e.currentTarget;
    const link = target.querySelector('a[data-link]');
    link.click();
  }

  const linksInCards = document.querySelectorAll('*[data-place]');
  if (linksInCards.length) {
    Array.prototype.slice.call(linksInCards).forEach((el) => {
      el.addEventListener('click', gotoLinkAnyPlaceInCard);
    });
  }

  RandomCollectionOnMainPage();

  toTopScrollButton();
});
