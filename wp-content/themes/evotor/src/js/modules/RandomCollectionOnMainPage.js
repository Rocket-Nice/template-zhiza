let firstClickPosition = false;

/**
 * Получить случайную коллекцию.
 * Событие срабатывает по нажатию на кубик Dice.
 * @returns {boolean}
 * @constructor
 */
export function RandomCollectionOnMainPage() {
  const randomCollectionContainer = document.querySelector('#random-collection-block');
  if (!randomCollectionContainer) {
    return false;
  }
  //
  const dice = document.querySelector('#dice');
  //
  dice.addEventListener('click', () => {
    const width = window.screen.width;
    if (changeMobileDiceHover(dice, width)) {
      query(randomCollectionContainer);
    }
  });
}

function query(randomCollectionContainer) {
  $.ajax({
    method: 'GET',
    url: '/wp-admin/admin-ajax.php',
    data: {
      'action': 'random_collection'
    },
    contentType: "application/json",
    beforeSend() {
      toggleLoadingOverlay();
      document.querySelector('.random-collection .preloader .random-text').textContent = getRandomText();
    },
    success: function (d) {
      const { data } = d;
      const fns = [changeImage, changeCollectionTitle, changeCollectionLink, changePostsList, changeDescription];
      fns.map(fn => fn(randomCollectionContainer, data))
    },
    complete() {
      setTimeout(() => {
        toggleLoadingOverlay();
      }, 3000);
    },
    error: function (a, b, c) {
      console.log(a, b, c);
    },
  });
}

function toggleLoadingOverlay() {
  const overlay = document.querySelector('.random-collection .preloader');
  setTimeout(() => {
    overlay.classList.toggle('visible');
    document.body.classList.toggle('body--disabled--mobile');
  }, 100);
}

function getRandomText() {
  const textVariants = [
    'Что ждёт ваш бизнес в этом году? Сейчас расскажем…',
    'Сейчас звёзды раскроют лучший совет для успешного успеха! Подождите секундочку…',
    'Происходит чисто предпринимательская магия. Подождите секундочку…',
    'Что ждёт ваш бизнес в ближайшее время? Сейчас расскажем…',
    'У-у-у! Наши карты и кофейная гуща откроют вам бизнес-секрет…сейчас-сейчас, ещё секундочку!',
  ];
  return textVariants[Math.floor(Math.random() * textVariants.length)];
}

/**
 * Всплывашка о подсказке появляется как картинка только в мобилке.
 * В мобилке из-за ховеров своё поведение.
 * 1. Первое нажатие показывает всплывашку.
 * 2. Второе нажатие закрывает всплывашку, и обновляет коллекцию.
 * 3. Все последующие нажатия до перезагрузки странницы уже не вызывают всплывашку.
 * @param {Element} dice
 * @param {int} width
 */
function changeMobileDiceHover(dice, width) {
  // Работает только для < 1280
  if (width >= 1280) {
    return true;
  }

  if (!firstClickPosition) {
    dice.classList.add('mobile-hover');
    firstClickPosition = true;
    return false;
  } else {
    dice.classList.remove('mobile-hover');
    return true;
  }
}

/**
 * Заменить изображение коллекции.
 * @param {Element} container
 * @param data
 */
function changeImage(container, data) {
  const img = container.querySelector('.img-wrapper img');
  img.src = data.image;
}

/**
 * Заменить содержимое заголовка коллекции.
 * @param {Element} container
 * @param data
 */
function changeCollectionTitle(container, data) {
  const title = container.querySelector('.collection-title');
  title.innerHTML = data.title;
}

/**
 * Заменить содержимое ссылки на коллекцию.
 * @param {Element} container
 * @param data
 */
function changeCollectionLink(container, data) {
  const link = container.querySelector('.btn-row a');
  link.href = data.link;
}

/**
 * Заменить содержимое трёх постов.
 * @param {Element} container
 * @param data
 */
function changePostsList(container, data) {
  const posts = container.querySelectorAll('.post-list .item');
  posts.forEach((item, i) => {
    const post = data['posts'][i];
    if (post) {
      const a = item.querySelector('a.title');
      item.classList.remove('hide-post');
      a.href = post['link'];
      a.innerHTML = post['title'];
      //
      const date = item.querySelector('.post-meta .date');
      date.innerHTML = post['date'];
    } else {
      item.classList.add('hide-post');
    }
  });
}

function changeDescription(container, data) {
  const description = container.querySelector('.info');
  description.innerHTML = data.description ? data.description : '';
}
