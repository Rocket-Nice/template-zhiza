import {keyUpPressed, moveCursorAtEndOfInput} from "../helpers";
import SearchOptions from "./search/SearchOptions";

(function () {
  const searchPanel = document.querySelector('#search-box');
  if (!searchPanel) {
    return;
  }

  const openBtn = document.querySelector('#open-search');
  const closeBtn = searchPanel.querySelector('#cross-hair');
  const searchInput = searchPanel.querySelector('input[name="s"]');

  const relevantOptions = new SearchOptions(searchInput, searchPanel);

  let isActive = false;

  /**
   * Открыть/закрыть форму поиска в шапке.
   */
  function changeState() {
    searchPanel.classList.toggle('open');
    isActive = !isActive;
  }

  /**
   * Закрыть строку поиска
   */
  function closeSearchBox() {
    searchPanel.classList.remove('open');
    isActive = false;
  }

  openBtn.addEventListener('click', () => {
    changeState();
    if (isActive) {
      setTimeout(() => {
        moveCursorAtEndOfInput(searchInput);
        relevantOptions.openOptions();
      }, 400);
    }
  });
  closeBtn.addEventListener('click', () => {
    changeState();
    relevantOptions.closeOptions();
  });

  document.body.addEventListener('click', closeSearchPanelIfClickOutside);

  /**
   *
   * @param {Event} e
   */
  function closeSearchPanelIfClickOutside(e) {
    const closest = e.target.closest('.search-form--wrapper');
    const crossHair = e.target.closest('.get_search');
    // closest нулевой, значит клик был вне шапки, следовательно, закрываем поисковую строку.
    if (closest || crossHair) {
      // Было нажатие по блоку относящемуся к форме поиска в шапке или кнопке открытия формы.
      return;
    }
    closeSearchBox();
    relevantOptions.closeOptions();
  }

  keyUpPressed('Escape', () => {
    if (isActive) {
      closeSearchBox();
    }
  });
})();


