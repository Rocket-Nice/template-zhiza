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
            beforeSend: function() {
                errorObj.css('display', 'none');
                btn.addClass('disabled');
                btn.val('Отправляем..');
            },
            success: function (data) {
                console.log('success');
                errorObj.css('display', 'none');
                successOjb.attr('style','display: block !important');
                btn.val('Отправлено');
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

    $('#menu_btn').click(function () {
        $('#m_menu').addClass('open')
        $('#all_apge_wrapper').addClass('open')
        $('body').addClass('menu_open')
    })

    $('#all_apge_wrapper .page_mask').click(function () {
        $('#m_menu').removeClass('open')
        $('#all_apge_wrapper').removeClass('open')
        $('body').removeClass('menu_open')
        $('#top_select').removeClass('open')
    })

    $('.header_search').click(function () {
        $('.search_box').addClass('open')
    })
    $('#search_close').click(function () {
        $('.search_box').removeClass('open')
    })


    $('.tests_carousel').owlCarousel({
        items: 4,
        nav: true,
        dots: true,
        loop: true,
        margin: 20,
        navText: [
          '<img src="/wp-content/themes/evotor/images/main_page/prev_white.svg" alt="" width="16" height="42">',
          '<img src="/wp-content/themes/evotor/images/main_page/next_white.svg" alt="" width="16" height="42">'
        ],
        autoplay: false,
        responsive: {
            0: {
                items: 1,
                navText: ['', ''],
                margin: 3,
                stagePadding: 20,
            },
            1200: {
                items: 4,
            }
        }
    })

    $('.n_video_carousel').owlCarousel({
        items: 1,
        nav: true,
        dots: true,
        loop: false,
        navText: [
          '<img src="/wp-content/themes/evotor/images/main_page/prev_white.svg" alt="" width="16" height="42">',
          '<img src="/wp-content/themes/evotor/images/main_page/next_white.svg" alt="" width="16" height="42">'
        ],
        autoplay: false,
        responsive: {
            0: {
                items: 1,
                margin: 3,
                stagePadding: 20,
            },
            1200: {
                items: 1,
            }
        }
    })

    $('.fond_carousel').owlCarousel({
        items: 3,
        nav: true,
        dots: true,
        loop: true,
        margin: 20,
        navText: ['<img src="/wp-content/themes/evotor/images/main_page/prev_black.svg" alt="">', '<img src="/wp-content/themes/evotor/images/main_page/next_black.svg" alt="">'],
        autoplay: false,
        responsive: {
            0: {
                items: 2,
                navText: ['', ''],
                margin: 3,
                stagePadding: 20,
            },
            1200: {
                items: 3,
            }
        }
    })

    $('.bot_carousel').owlCarousel({
        items: 4,
        nav: true,
        autoWidth: false,
        dots: true,
        loop: true,
        margin: 20,
        navText: ['<img src="/wp-content/themes/evotor/images/main_page/prev_black.svg" alt="">', '<img src="/wp-content/themes/evotor/images/main_page/next_black.svg" alt="">'],
        autoplay: false,
        responsive: {
            0: {
                items: 1,
                navText: ['', ''],
                margin: 3,
                autoWidth: false,
                stagePadding: 20,
            },
            1200: {
                items: 4,
            }
        }
    })

    $('.n_podbor_carousel').owlCarousel({
        items: 4,
        nav: true,
        dots: true,
        loop: true,
        margin: 20,
        navText: ['<img src="/wp-content/themes/evotor/images/main_page/prev_black.svg" alt="">', '<img src="/wp-content/themes/evotor/images/main_page/next_black.svg" alt="">'],
        autoplay: false,
        responsive: {
            0: {
                items: 2,
                navText: ['', ''],
                margin: 3,
                nav: true,
                stagePadding: 20,
            },
            1200: {
                items: 4,
                nav: true,
            }
        }
    })

    $('.n_podbor_carousel_page').owlCarousel({
        items: 4,
        nav: true,
        dots: true,
        loop: false,
        margin: 20,
        navText: ['<img src="/wp-content/themes/evotor/images/main_page/prev_orange.svg" alt="">', '<img src="/wp-content/themes/evotor/images/main_page/next_orange.svg" alt="">'],
        autoplay: false,
        responsive: {
            0: {
                items: 2,
                navText: ['', ''],
                margin: 3,
                autoWidth: false,
                stagePadding: 20,
            },
            1200: {
                items: 4,
            }
        }
    })

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
    })


    $('.other_podcast_carousel').owlCarousel({
        nav: false,
        dots: false,
        loop: false,
        autoplay: false,
        responsive: {
            0: {
                items: 1,
                margin: 8,
                stagePadding: 20,
                mouseDrag: true,
            },
            1200: {
                items: 2,
                margin: 18,
                mouseDrag: false,
            }
        }


    })


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
    })


    $('.vis_more').click(function () {
        var my_parent = $(this).parent()
        var my_height = $('.vis_block .box', my_parent).height();
        $('.vis_block', my_parent).css('height', my_height)
        $('.vis_block', my_parent).addClass('open')
        $(this).addClass('none')
    })

});
