class SearchOptions {
  /**
   * Отображение и запросы релевантных введённом слову в поисковую строку опций.
   * @param {HTMLInputElement} inputSearch Поле ввода
   * @param {HTMLElement} searchBox Выпадающее окно с полем ввода
   */
  constructor(inputSearch, searchBox) {
    this.inputSearch = inputSearch;
    this.searchBox = searchBox;
    //
    this.isOpen = false;
    /**
     * Обертка блока с подсказками.
     * @type {Element}
     */
    this.optionsWrapper = searchBox.querySelector('.relevant-options');
    this.optionsEmpty = false; // По умолчанию есть предложения по поиску из 5 элементов.
    //
    this.timeout = null;
    this.inputWasStart = null;
    this.init();
  }

  init() {
    this.inputSearch.addEventListener('input', () => {
      this.userInput();
    });
  }

  /**
   * Обработка пользовательского ввода в строку поиска.
   */
  userInput() {
    const self = this;
    if (!this.inputWasStart) {
      console.info('Help relevant options was removed.');
      this.clearRelevantOptions();
      this.inputWasStart = true;
    }
    clearTimeout(this.timeout);

    this.timeout = setTimeout(() => {
      self.inputEnd().then();
    }, 1000);
  }

  /**
   * Удалить начальные подсказки поиска и скрыть панель подсказок.
   */
  clearRelevantOptions() {
    const wrapper = this.optionsWrapper;
    const list = wrapper.querySelector('.options-list');
    list.innerHTML = '';
    list.classList.remove('basic');
    this.optionsEmpty = true;
    this.closeOptions();
  }

  /**
   * Закрыть окно подсказок
   */
  closeOptions() {
    this.isOpen = false;
    this.optionsWrapper.classList.remove('visible');
  }

  /**
   * Открыть окно подсказок
   */
  openOptions() {
    console.log('openOptions', this.optionsEmpty);
    if (!this.optionsEmpty) {
      this.isOpen = true;
      this.optionsWrapper.classList.add('visible')
    }
  }

  /**
   * @return {boolean} Пуста ли строка ввода поиска.
   */
  inputSearchIsEmpty() {
    return this.inputSearch.value.length <= 1;
  }

  /**
   * Получить введённое значение.
   * @return {string}
   */
  inputSearchTerm() {
    return this.inputSearch.value;
  }

  /**
   * Пользователь закончил ввод, после чего, если строка не пустая (больше 2 символов,
   * скрываем блок с начальными подсказками, делаем запрос на получение результатов поиска.
   */
  async inputEnd() {
    const self = this;

    if (this.inputSearchIsEmpty()) {
      this.clearRelevantOptions();
      this.optionsEmpty = true;
      return;
    }
    await this.queryPosts().then((data) => {
      self.closeOptions();
      self.renderNewFindPost(data);
    });
  }

  /**
   * Запросить 5 статей подходящих по фразе к введённой в поисковую строку.
   * @return {Promise<any>}
   */
  queryPosts() {
    const searchValue = this.inputSearchTerm();
    return fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      credentials: 'same-origin',
      headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
      body: new URLSearchParams({
        action: 'partial_search_term',
        searchTerm: searchValue,
      }),
    }).then((res) => res.json())
      .then((data) => {
        return data;
      })
      .catch((err) => {
        console.error('fetch error', err);
      });
  }

  /**
   * Отрисовка в список новых найденных статей по запросу.
   * @param data
   * @return {Promise<void>}
   */
  renderNewFindPost(data) {
    const wrapper = this.optionsWrapper;
    const list = wrapper.querySelector('.options-list');
    //
    let resultHtml = '';
    data.data.posts.forEach((el, i) => {
      resultHtml += `<li class="option"><a href="${el.url}" tabindex="${i}">${el.title}</a></li>`
    });
    //console.log(resultHtml);
    list.innerHTML = resultHtml;
    this.optionsEmpty = false;
    if (data.data.found > 0) { // Если не было найдено результатов, не открываем окно подсказок
      this.openOptions();
    }
  }
}

export default SearchOptions;
