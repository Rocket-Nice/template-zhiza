// TODO устаревший код старой темы.

$(document).ready(function () {
  /**
   * Show more blog page
   * @type {*}
   */
  var showMoreButton = $('.blog__more');
  var countContainer = $('.blog__count');
  var page = 2;
  var container = $('#blog__items');
  showMoreButton.click(function () {
    showMoreButton.hide();
    countContainer.hide();
    var data = {
      'action': 'show_more_blog_action',
      'page': page,
      'category': $('#category-id').val()
    };
    jQuery.post(ajaxurl, data, function (response) {
      if (response.result === true) {
        container.append(response.html);
        if (response.showmore === true) {
          showMoreButton.show();
        }
        page++;
      }
    });
  });

  /**
   * Obscene
   */
  var obsceneSwitcher = $('.obscene__container'),
    articleContent = $('#article-content');

  obsceneSwitcher.find('.obscene__item').click(function () {
    if ($(this).hasClass('no__obscene')) {
      if (!obsceneSwitcher.hasClass('active-1')) {
        articleContent
          .find('span.obscene .with').css('display', 'none');
        articleContent
          .find('span.obscene .no').css('display', 'inline');
        obsceneSwitcher
          .removeClass('active-2')
          .addClass('active-1');
      }
    } else {
      if (!obsceneSwitcher.hasClass('active-2')) {
        articleContent
          .find('span.obscene .no').css('display', 'none');
        articleContent
          .find('span.obscene .with').css('display', 'inline');
        obsceneSwitcher
          .removeClass('active-1')
          .addClass('active-2');
      }
    }
  });

  /**
   * Share
   */
  var sharing = $('#sharing-bottom,#sharing-top');
  var image = $('#block-img img').attr('src');
  var text = $('h1').text();
  var description = $('#subheadline').text();

  // facebook
  sharing.find('.article__social__fb').click(function (event) {
    console.log(image);
    console.log(text);
    console.log(description);
    event.preventDefault();
    /*FB.ui({
        method: 'feed',
        link: window.location.href,
        caption: 'Evotor.ru',
        picture: image,
        name: text,
        description: description
    }, function(response){});*/

    var url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href);
    window.open(url, 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });

  sharing.find('.article__social__telegram').click(function (event) {
    event.preventDefault();

    var url = 'https://telegram.me/share/url?';
    url += 'text=' + encodeURIComponent(text);
    url += '&url=' + encodeURIComponent(window.location.href);
    window.open(url, 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });

  // vk
  sharing.find('.article__social__vk').click(function (event) {
    console.log(image);
    event.preventDefault();
    var url = 'http://vkontakte.ru/share.php?';
    url += 'url=' + encodeURIComponent(window.location.href);
    url += '&title=' + encodeURIComponent(text);
    url += '&description=' + encodeURIComponent(description);
    url += '&image=' + encodeURIComponent(image);
    url += '&noparse=true';
    window.open(url, 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });

  // article h3
  var article = $('#article-content');
  /*if(article.html() !== undefined){
      article.find('p:nth-child(4)').css('display','none');
  }*/
});

/**
 * Validate email
 * @param email
 * @returns {boolean}
 */
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
