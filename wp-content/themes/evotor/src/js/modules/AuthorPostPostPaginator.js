import {gup, spanToLinkCurrentPage, setQueryStringParameter, changeCurrentInPaginator} from '../helpers';

(function () {
  const authorPosts = document.querySelector('.author--posts');
  const paginator = document.querySelector('.paginator');
  const pageAuthor = document.querySelector('main.page-author');

  if (!authorPosts || !paginator || !pageAuthor) {
    return;
  }

  const postsList = pageAuthor.querySelector('.post--list');
  let downloading = false;
  let page = +(gup('pg')) || 1;
  let nextPage = page + 1;
  const maxNumPages = +paginator.dataset['max_pages'];
  const currentPage = +paginator.dataset['current'];
  spanToLinkCurrentPage(paginator, currentPage);

  window.addEventListener('scroll', onScroll);

  /**
   *
   * @param {Event} e
   * @returns {Promise<void>}
   */
  async function onScroll(e) {
    const offset = paginator.getBoundingClientRect().bottom;
    if (offset < 1150 && !downloading && page < maxNumPages) {
      downloading = true;
      await getNextPage()
        .then(successCallback)
        .catch((err) => {
          console.error('err', err);
        });
    }
  }

  /**
   *
   * @returns {Promise<any>}
   */
  async function getNextPage() {
    console.log(`Now is '${page}' page. Requesting '${nextPage}' page`);

    return fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      credentials: 'same-origin',
      headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
      body: new URLSearchParams({
        action: 'author_page_next_page',
        authorSlug: pageAuthor.dataset.author_slug,
        postType: pageAuthor.dataset.post_type,
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
   * Обработчик успешного получения данных следующей страницы
   * @param {boolean} data.status
   * @param {string} data.data.items
   */
  async function successCallback(data) {
    if (!data.status) {
      return null;
    }

    const parser = new DOMParser();
    const result = parser.parseFromString(data.data.items, 'text/html');
    const items = result.body.children;
    const itemsArr = [...items];
    itemsArr.forEach((el) => {
      postsList.appendChild(el);
    });
    setQueryStringParameter('pg', nextPage);
    page++;
    nextPage++;
    changeCurrentInPaginator(paginator);
    downloading = false;
  }
})();
