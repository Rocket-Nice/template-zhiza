$(document).ready(function () {
  $("#new_subscribe_form_foot").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    let btn = form.find('input[type=submit]');

    let errorObj = $('#footer_error_form');
    let successOjb = $('#foot');

    var my_mail = $('input[name=mail]', this).val();

    var data = JSON.stringify({
      'email': my_mail,
      'type': 'ZHIZA',
      'source': window.location.href,
    });

    $.ajax({
      method: 'POST',
      url: 'https://newsletters.evotor.ru/api/v1/newsletters/subscribe',
      data: data,
      contentType: "application/json",
      beforeSend: function () {
        errorObj.css('display', 'none');
        btn.addClass('disabled');
        btn.val('Отправляем..');
      },
      success: function (data) {
        console.log('success');
        errorObj.css('display', 'none');
        successOjb.attr('style', 'display: block !important');
        btn.val('Отправлено');

        // Для гугл-аналитики
        dataLayer.push({
          'event': 'evotorblog',
          'eventCategory': 'подписка',
          'eventAction': 'подвал', // Обозначение местоположения формы
          'eventLabel': window.location.href,
        });
      },
      error: function (a, b, c) {
        console.log(a, b, c);

        btn.val('Отправить');
        errorObj.css('display', 'block');
        successOjb.css('display', 'none');
        btn.removeClass('disabled');
      }
    });
  });

  // $('#menu_btn').click(function () {
  //   $('#m_menu').addClass('open')
  //   $('#all_apge_wrapper').addClass('open')
  //   $('body').addClass('menu--open')
  // })
  //
  // $('#all_apge_wrapper .page_mask').click(function () {
  //   $('#m_menu').removeClass('open')
  //   $('#all_apge_wrapper').removeClass('open')
  //   $('body').removeClass('menu--open')
  //   $('#top_select').removeClass('open')
  // })
  //
  // $('.header_search').click(function () {
  //   $('.search_box').addClass('open')
  // });
  //
  // $('#search_close').click(function () {
  //   $('.search_box').removeClass('open')
  // });

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



  $('.pd_box_mob').owlCarousel({
    items: 1,
    nav: false,
    dots: false,
    loop: false,
    navText: ['', ''],
    autoplay: false,
    margin: 1,
    stagePadding: 40,
    autoHeight: true
  });


  $('#n_fond .tab_li li').click(function () {
    if ($(this).hasClass('active')) {
    } else {
      var my_id = $(this).attr('data-tab')
      $('#n_fond .tab_li li').removeClass('active')
      $(this).addClass('active')
      $('#n_fond .tab_content .tab_box').removeClass('visible')
      $('#n_fond .tab_content .tab_box').removeClass('active')
      $('#n_fond .tab_content .tab_box#' + my_id + '').addClass('active')
      setTimeout(() => $('#n_fond .tab_content .tab_box#' + my_id + '').addClass('visible'), 500);

    }
  });

  $('.vis_more').click(function () {
    var my_parent = $(this).parent()
    var my_height = $('.vis_block .box', my_parent).height();
    $('.vis_block', my_parent).css('height', my_height)
    $('.vis_block', my_parent).addClass('open')
    $(this).addClass('none')
  });

  $('#new_post table').each(function (index, value) {
    var headerCount = $(this).find('th').length;
    for (i = 0; i <= headerCount; i++) {
      var headerLabel = $(this).find('th:nth-child(' + i + ')').text();
      $(this).find('tr td:not([colspan]):nth-child(' + i + ')').replaceWith(
        function () {
          return $('<td data-label="' + headerLabel + '"><span class="m_th">' + headerLabel + '</span>').append($(this).contents());
        }
      );
    }
  });
});
