$("#new_subscribe_form_foot").submit(function (e) {
  e.preventDefault();

  const form = $(this);
  let btn = form.find('input[type=submit]');

  let errorObj = $('#footer_error_form');
  let successOjb = $('#foot');

  const my_mail = $('input[name=mail]', this).val();

  const data = JSON.stringify({
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
