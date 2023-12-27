const Masonry = require('masonry-layout');

const collectionGrid = document.querySelector('.collection-grid');

if (collectionGrid) {
  document.addEventListener('DOMContentLoaded', function () {
    const layout = new Masonry('.collection-grid', {
      columnWidth: '.collection-card',
      gutter: 24,
      horizontalOrder: true,
      percentPosition: true
    });

    layout.layout();
    layout.reloadItems();

    layout.once( 'layoutComplete', function() {
      layout.layout();
      layout.reloadItems();
    });

    window.addEventListener('resize', ()=> {
      layout.layout();
      layout.reloadItems();
    });
    document.addEventListener('scroll', ()=> {
      layout.layout();
      layout.reloadItems();
    })


    const pageCollection = document.querySelector('main.page-collection');
    const collectionGrid = document.querySelector('.collection-grid');
    const paginator = document.querySelector('.paginator');

    if (pageCollection && paginator) {
      let downloading = false;
      let page = +(gup('pg')) || 1;
      let nextPage = page + 1;
      const maxNumPages = +paginator.dataset['max_pages'];
      const currentPage = paginator.dataset['current'];
      spanToLinkCurrentPage();

      window.addEventListener('scroll', async function (e) {
        const offset = paginator.getBoundingClientRect().bottom;

        /**
         * 1150 - условный отступ от блока пагинации, когда надо начать загрузку новой страницы
         */
        if (offset < 1150 && !downloading && page < maxNumPages) {
          downloading = true;
          //
          await getNextPage()
            .then(successCallback)
            .catch((err) => {
              console.error('err', err);
            });
        }
      });


      /**
       * Обработчик успешного получения данных следующей страницы
       * @param {boolean} data.status
       * @param {string} data.data.items
       */
      async function successCallback(data) {
        if (data.status) {
          const masonryLayout = layout;
          //
          const parser = new DOMParser();
          const result = parser.parseFromString(data.data.items, 'text/html');
          const items = result.body.children;

          // Обновление сетки Masonry
          const itemsArr = [...items];
          itemsArr.forEach((el) => {
            collectionGrid.appendChild(el);
            masonryLayout.appended(el);
            el.addEventListener('click', gotoLinkAnyPlaceInCard);
          });
          masonryLayout.layout();
          //

          downloading = false;
          setQueryStringParameter('pg', nextPage);
          page++;
          nextPage++;
          changeCurrentInPaginator();
        }
      }


      /**
       * Запрос карточек новой страницы страницы.
       * @returns {Promise<any>}
       */
      async function getNextPage() {
        console.log(`Now is '${page}' page. Requesting '${page + 1}' page`);

        return fetch('/wp-admin/admin-ajax.php', {
          method: 'POST',
          credentials: 'same-origin',
          headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
          body: new URLSearchParams({
            action: 'collections_next_page',
            postId: pageCollection.dataset.post_id,
            postType: pageCollection.dataset.post_type,
            page: +page + 1,
          })
        }).then((res) => res.json())
          .then((data) => {
            return data;
          })
          .catch((err) => {
            console.error('fetch error', err);
          });
      }


      /**
       * Меняет в URL get параметр. Если get параметр не был задан, будет создан.
       * @param name имя get параметра
       * @param value значение get параметра
       */
      function setQueryStringParameter(name, value) {
        const params = new URLSearchParams(window.location.search);
        params.set(name, value);
        window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}?${params}`));
      }


      /**
       * Изменение текущей страницы в пагинации
       */
      function changeCurrentInPaginator() {
        const current = paginator.querySelector('.current');
        const next = current.nextElementSibling;
        //
        current.classList.remove('current');
        next.classList.add('current');
      }


      function spanToLinkCurrentPage() {
        const span = paginator.querySelector('span.current');
        //
        const a = document.createElement('a');
        a.innerHTML = span.innerHTML;
        a.href = location.pathname + '?pg=' + currentPage;
        a.ariaCurrent = 'page';
        a.classList.add('page-numbers', 'current');
        //
        span.parentNode.replaceChild(a, span);
      }
    }


    /**
     * Получить GET параметр из ссылки
     * @param name - имя GET параметра
     * @param url - по умолчанию текущий URL.
     * @returns {null|string}
     */
    function gup(name, url = location.href) {
      name = name.replace(/\[/, "\\\[").replace(/]/, "\\\]");
      const regexS = "[\\?&]" + name + "=([^&#]*)";
      const regex = new RegExp(regexS);
      const results = regex.exec(url);
      //
      return results == null ? null : results[1];
    }


// При нажатии на любой элемент не являющийся ссылкой, перейти в ссылке с [data-link] атрибутом.
    const collectionsCard = document.querySelectorAll('.collection-card');
    if (collectionsCard.length) {
      Array.prototype.slice.call(collectionsCard).forEach((el) => {
        el.addEventListener('click', gotoLinkAnyPlaceInCard);
      });
    }

    function gotoLinkAnyPlaceInCard(e) {
      const target = e.currentTarget;
      const link = target.querySelector('a[data-link]');
      link.click();
    }

  });
}
