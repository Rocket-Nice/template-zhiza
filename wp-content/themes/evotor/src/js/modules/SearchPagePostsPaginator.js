import {
  gup,
  spanToLinkCurrentPage,
  setQueryStringParameter,
  changeCurrentInPaginator,
  changeFirstPageOfPagination
} from '../helpers';

(function () {
  const foundResults = document.querySelector('.found-results');
  const paginator = document.querySelector('.paginator');
  const pageSearch = document.querySelector('main.page-search');

  if (!foundResults || !paginator || !pageSearch) {
    return;
  }

  const postList = foundResults.querySelector('.post--list');
  let downloading = false;
  let page = +(gup('pg')) || 1;
  let nextPage = page + 1;
  const maxNumPages = +paginator.dataset['max_pages'];

  window.addEventListener('scroll', onScroll);

  spanToLinkCurrentPage(paginator, page, 'span.current', `&s=${pageSearch.dataset.searchTerm}`);
  setQueryStringParameter('s', pageSearch.dataset.searchTerm);

  /**
   *
   * @param {Event} e
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
   * @returns {Promise<void>}
   */
  async function getNextPage() {
    console.log(`Now is '${page}' page. Requesting '${nextPage}' page`);
    return fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      credentials: 'same-origin',
      headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
      body: new URLSearchParams({
        action: 'search_page_next_page',
        searchTerm: pageSearch.dataset.searchTerm,
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
   *
   * @param data
   * @returns {Promise<void>}
   */
  async function successCallback(data) {
    if (!data.status) {
      return null;
    }

    const parser = new DOMParser();
    const result = parser.parseFromString(data.data.items, 'text/html');
    const new_paginate = (new DOMParser()).parseFromString(data.data.paginate, 'text/html');
    let items = result.body.children;
    let itemsArr = [...items];
    itemsArr.forEach((el) => {
      postList.appendChild(el);
    });
    setQueryStringParameter('pg', nextPage);
    //
    paginator.innerHTML = '';
    items = new_paginate.body.children;
    itemsArr = [...items];
    itemsArr.forEach((el) => {
      paginator.appendChild(el);
    });
    page++;
    nextPage++;
    // changeCurrentInPaginator(paginator);
    downloading = false;
    //
    const search = pageSearch.dataset.searchTerm;
    spanToLinkCurrentPage(paginator, page, 'span.current', `&s=${search}`);
    setQueryStringParameter('s', search);
    //
    changeFirstPageOfPagination(paginator, `s=${search}`);
  }
})();
