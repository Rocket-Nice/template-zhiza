/**
 * Получить GET параметр из ссылки
 * @param name - имя GET параметра
 * @param url - по умолчанию текущий URL.
 * @returns {null|string}
 */
export function gup(name, url = location.href) {
  name = name.replace(/\[/, "\\\[").replace(/]/, "\\\]");
  const regexS = "[\\?&]" + name + "=([^&#]*)";
  const regex = new RegExp(regexS);
  const results = regex.exec(url);
  //
  return results == null ? null : results[1];
}


/**
 * Заменяет в переданном пагинаторе элемент текущей страницы, на ссылку с GET параметром равным текущей странице.
 * @param {HTMLDivElement} paginator Пагинатор.
 * @param {number} currentPage Номер текущей страницы.
 * @param {string} selectorCurrentPage Селектор элемента текущей страницы в пагинаторе.
 * @param {string} additionalArgs дополнительные GET параметры. Например "&otherPx=1&otherPy=2".
 */
export function spanToLinkCurrentPage(paginator, currentPage = 1, selectorCurrentPage = 'span.current', additionalArgs = '') {
  const span = paginator.querySelector(selectorCurrentPage);
  //
  const a = document.createElement('a');
  a.innerHTML = span.innerHTML;
  a.href = location.pathname + '?pg=' + currentPage + additionalArgs;
  a.ariaCurrent = 'page';
  a.classList.add('page-numbers', 'current');
  //
  span.parentNode.replaceChild(a, span);
}


/**
 * Меняет в URL get параметр. Если get параметр не был задан, будет создан.
 * @param name имя get параметра
 * @param value значение get параметра
 */
export function setQueryStringParameter(name, value) {
  const params = new URLSearchParams(window.location.search);
  params.set(name, value);
  window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}?${params}`));
}


/**
 * Переносит активную страницу на следующий элемент пагинатора.
 * @param {HTMLDivElement} paginator Пагинатор.
 */
export function changeCurrentInPaginator(paginator) {
  const current = paginator.querySelector('.current');
  const next = current.nextElementSibling;
  //
  current.classList.remove('current');
  next.classList.add('current');
}


/**
 * Устанавливает ссылку в "Текущий адрес/?args"
 * @param {HTMLDivElement} paginator Пагинатор.
 * @param {string} args Пример: "s=termS&termY".
 */
export function changeFirstPageOfPagination(paginator, args) {
  const first = paginator.firstChild;
  const a = document.createElement('a');
  a.innerHTML = first.innerHTML;
  a.classList.add('page-numbers');
  a.href = `${location.pathname}./?${args}`;
  first.parentNode.replaceChild(a, first);
}


/**
 * Перемещение курсора в конец.
 * @param {HTMLInputElement} input
 */
export function moveCursorAtEndOfInput(input) {
  if (!input) {
    return;
  }
  // Установка курсора в конец строки
  input.focus()
  if (typeof input.selectionStart == "number") {
    input.selectionStart = input.selectionEnd = input.value.length;
  } else if (typeof input.createTextRange != "undefined") {
    const range = input.createTextRange();
    range.collapse(false);
    range.select();
  }
}

/**
 *
 * @param {string} key
 * @param {function} cb
 */
export function keyUpPressed(key, cb) {
  document.addEventListener('keyup', handler);

  /**
   * @param {KeyboardEvent} e
   */
  function handler(e) {
    if (e.key === key) {
      console.info(`Key [${key}] pressed.`);
      cb(e);
    }
  }
}
