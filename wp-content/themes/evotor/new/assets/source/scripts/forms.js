(function($){
    let App = {
        init : function () {
            let that = this;
            that.calendar();
            that.form(that);
            that.framePopup();
        },

        getCookie: function (name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        },
        isEmail: function (email) {
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        },
        calendar : function () {
            let input = $("input#date");
            if (input.length) {
                // $.extend($.datepicker,{_checkOffset:function(inst,offset,isFixed){return offset}});
                $("input#date").datepicker({
                    changeYear: true,
                    changeMonth: true,
                    showOtherMonths: true,
                    dateFormat: "dd.mm.yy",
                    selectOtherMonths: true,
                    closeText: "Закрыть",
                    prevText: "&#x3C;Пред",
                    nextText: "След&#x3E;",
                    monthNames: [
                        "Январь",
                        "Февраль",
                        "Март",
                        "Апрель",
                        "Май",
                        "Июнь",
                        "Июль",
                        "Август",
                        "Сентябрь",
                        "Октябрь",
                        "Ноябрь",
                        "Декабрь"
                    ],
                    monthNamesShort: [
                        "Янв",
                        "Фев",
                        "Мар",
                        "Апр",
                        "Май",
                        "Июн",
                        "Июл",
                        "Авг",
                        "Сен",
                        "Окт",
                        "Ноя",
                        "Дек"
                    ],
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: "",
                    defaultDate: "-30y",
                    beforeShow: function(input) {
                        let ert = $(input).data('id');
                        $('#ui-datepicker-div').addClass(ert);
                    }
                    // beforeShow: function(input) {
                    //     setTimeout(function() {
                    //         let month = $(input).datepicker("widget").find(".ui-datepicker-month");
                    //         let year = $(input).datepicker("widget").find(".ui-datepicker-year");
                    //         // month.attr('size', '5');
                    //         month.on('focus', function () {
                    //             $(this).attr('size', '5');
                    //         });
                    //         month.on('blur', function () {
                    //             $(this).attr('size', '1');
                    //         });
                    //         month.on('onchange', function () {
                    //             $(this).attr('size', '1').blur();
                    //         })
                    //
                    //     });
                    // }
                    // beforeShow : function(input,inst){
                    //     let offset = $(input).offset();
                    //     let height = $(input).height();
                    //     window.setTimeout(function () {
                    //         $(inst.dpDiv).css({ top: (offset.top + height) + 'px', left:offset.left + 'px' })
                    //     }, 1);
                    // }
                });
                // $.extend($.datepicker,{_checkOffset:function(inst,offset,isFixed){offset.top = offset.top - 290; offset.left = offset.left + 240; return offset;}});
            }
        },
        framePopup: function () {
            let link = $('.iframe-popup');
            if (link.length) {
                link.magnificPopup({
                    type:'iframe',
                    closeBtnInside:true,
                    alignTop: true,
                    removalDelay: 200,
                    callbacks: {
                        beforeOpen: function() {
                            this.st.iframe.markup = this.st.iframe.markup.replace('mfp-iframe-scaler', 'mfp-iframe-scaler mfp-with-anim');
                            this.st.mainClass = 'mfp-move';
                        }
                    },
                });
            }
        },
    };
    App.init();

})(jQuery);

// let hash = location.hash.substring(1);
// if (hash) {
//     $('.content-page--after').hide();
//     $('#' + hash).show().addClass('show');
// }


$('.btn-n--email').on('click', function (e) {
    e.preventDefault();
    $(this).closest('.form-n-single').find('.email-field').val('').attr('value', '').focus();
});

$('input[name=why3_1]').on('input', function () {
    $(this).closest('.field-subscribe').find('input[name=why]').attr('checked', true).trigger('click');
});

( function() {
    let youtube = document.querySelectorAll( ".youtube" );
    for (let i = 0; i < youtube.length; i++) {
        let source = "https://img.youtube.com/vi/"+ youtube[i].dataset.embed +"/sddefault.jpg";
        let image = new Image();
        image.src = source;
        $(image).attr('alt', 'Миниатюра видео youtube');
        image.addEventListener( "load", function() {
            youtube[ i ].appendChild( image );
        }( i ) );
        youtube[i].addEventListener( "click", function() {
            let iframe = document.createElement( "iframe" );
            iframe.setAttribute( "frameborder", "0" );
            iframe.setAttribute( "allowfullscreen", "" );
            iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=1" );
            this.innerHTML = "";
            this.appendChild( iframe );
        } );
    }
} )();
