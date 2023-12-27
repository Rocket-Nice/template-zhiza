"use strict";

var grid;

$(document).ready(function(){
    grid = $('.grid');
    grid.posts();
    $('.evotor-stories__tasks').tasks();
    $('.container').blogWidth();
    $('.evotor-stories__money').money();
});

$(window).load(function(){
    console.log('sdf');
    $('.evotor-stories__left .about-blog').mCustomScrollbar();
});

$(window).resize(function(){
    grid.posts();
});

(function($){
    $.fn.posts = function(){
        if(grid.width() > 320){
            var columns = 2;

            if(grid.width() < 640){
                columns = 1;
            }

            if(grid.width() > 900 && grid.width() < 1500){
                columns = 3;
            }

            if(grid.width() > 1500){
                columns = 4;
            }

            grid.find('.post').each(function(){
                $(this).width( (grid.width() / columns ) - 20 );
            });

            grid.masonry({
                // options
                itemSelector: '.post',
                columnWidth: grid.width() / columns
            });
        }
    };

    $.fn.money = function(){
        var container = $(this);

        var showButton = container.find('.evotor-stories__money-show');
        var closeButton = container.find('.evotor-stories__money-close');
        showButton.click(function(){
            container.find('.hide').slideDown(100);
            showButton.fadeOut(100);
            closeButton.fadeIn(100);
        });

        closeButton.click(function(){
            container.find('.hide').slideUp(100);
            closeButton.fadeOut(100);
            showButton.fadeIn(100);
        });
        
        // mobile 
        $('.mobile-show-all-time').click(function(){
            container.find('.hide').slideDown(100);

            $(this).remove();
        });
    };

    $.fn.blogWidth = function(){
        var container = $(this);
        var header = $('header');
        var days = 365;


        // desktop
        container.find('.button-close-left').click(function(){
            // set cookie
            $.cookie("stories_show_left_block", true, { expires: days });

            // hide
            container.find('.evotor-stories__left').animate({'marginLeft': -1080}, 500);
            container.find('.evotor-stories__right').animate({'marginLeft':'60px'}, 500, function(){
                header.slideDown(100);
                grid.posts();
            });
        });

        header.find('.show-more').click(function(){
            header.slideUp(100,function(){
                container.find('.evotor-stories__left').animate({'marginLeft': 0}, 500);
                container.find('.evotor-stories__right').animate({'marginLeft':'540px'}, 500, function(){
                    grid.posts();
                });
            });

            $.cookie("stories_show_left_block", false, { expires: days });
        });

        // mobile
        container.find('.button-mobile').click(function(){
            if($(this).attr('data-action') === 'close'){
                container.find('.about-blog-container').slideUp(200);
                $(this)
                    .text($(this).attr('data-show-text'))
                    .removeClass('button-close-mobile')
                    .addClass('button-show-mobile');
                $(this).attr('data-action','show');
                $.cookie("stories_show_left_block", false, { expires: days });
            }else{
                container.find('.about-blog-container').slideDown(200);
                $(this)
                    .text($(this).attr('data-close-text'))
                    .removeClass('button-show-mobile')
                    .addClass('button-close-mobile');
                $(this).attr('data-action','close');
                $.cookie("stories_show_left_block", true, { expires: days });
            }
        });

    };

    $.fn.tasks = function(){
        var container = $(this);

        container.find('#show-more').click(function(){
            var button = $(this);
            container.find('.hide-items').slideDown(150,function(){
                button .remove();
            });

        });
    };
})( jQuery );

/**
 * Detect mobile
 * @returns {boolean}
 */
function isMobile(){
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}