"use strict";

function cardMediaLoader() {
    $(".card__media img").each(function () {
        var e = $(this).attr("src");
        $(this).parent().css({
            "background-image": "url(" + e + ")"
        })
    })
}

function isEmail(e) {
    var i = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return i.test(e)
}

$(document).ready(function () {
    cardMediaLoader()
});
$(document).ready(function () {
    $(".article .cut").on("click", function () {
        $(this).parent().removeClass("article--collapsed"), $(this).remove()
    })
}), function (e) {
    var i = {
        init: function () {
            var e = this;
            e.calendar();
            e.framePopup();
        },
        getCookie: function (e) {
            var i = document.cookie.match(new RegExp("(?:^|; )" + e.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"));
            return i ? decodeURIComponent(i[1]) : void 0
        },
        isEmail: function (e) {
            var i = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return i.test(e)
        },
        calendar: function () {
            var i = e("input#date");
            i.length && e("input#date").datepicker({
                changeYear: !0,
                changeMonth: !0,
                showOtherMonths: !0,
                dateFormat: "dd.mm.yy",
                selectOtherMonths: !0,
                closeText: "Закрыть",
                prevText: "&#x3C;Пред",
                nextText: "След&#x3E;",
                monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                monthNamesShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
                firstDay: 1,
                isRTL: !1,
                showMonthAfterYear: !1,
                yearSuffix: "",
                defaultDate: "-30y",
                beforeShow: function (i) {
                    var t = e(i).data("id");
                    e("#ui-datepicker-div").addClass(t)
                }
            })
        },
        framePopup: function () {
            var i = e(".iframe-popup");
            i.length && i.magnificPopup({
                type: "iframe",
                closeBtnInside: !0,
                alignTop: !0,
                fixedContentPos: true,
                removalDelay: 200,
                callbacks: {
                    beforeOpen: function () {
                        this.st.iframe.markup = this.st.iframe.markup.replace("mfp-iframe-scaler", "mfp-iframe-scaler mfp-with-anim");
                        this.st.mainClass = "mfp-move";
                    }
                }
            })
        },
    };
    i.init()
}(jQuery);

$(".btn-n--email").on("click", function (e) {
    e.preventDefault();
    $(this).closest(".form-n-single").find(".email-field").val("").attr("value", "").focus();
});

$("input[name=why3_1]").on("input", function () {
    $(this).closest(".field-subscribe").find("input[name=why]").attr("checked", !0).trigger("click").val($(this).val())
}),
    function () {
        for (var e = document.querySelectorAll(".youtube"), i = function (i) {
            var t = "https://img.youtube.com/vi/" + e[i].dataset.embed + "/sddefault.jpg",
                o = new Image;
            o.src = t, $(o).attr("alt", "Миниатюра видео youtube"), o.addEventListener("load", function () {
                e[i].appendChild(o)
            }(i)), e[i].addEventListener("click", function () {
                var e = document.createElement("iframe");
                e.setAttribute("frameborder", "0"), e.setAttribute("allowfullscreen", ""), e.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1"), this.innerHTML = "", this.appendChild(e)
            })
        }, t = 0; t < e.length; t++) i(t)
    }(), $(document).ready(function () {
    $(".level .close").on("click", function () {
        $(this).parent().fadeOut()
    })
});

$(document).ready(function () {
    if ($("#loadMoreCategory").length) var e = 24,
        i = 1;
    $("#loadMoreCategory").click(function () {
        var t = e * i,
            o = $(this),
            n = o.text();
        o.text("Загружаем..."), $.post(ajaxurl, {
            action: "load_more_category",
            category: o.attr("data-category"),
            offset: t,
            ppp: e
        }).done(function (e) {
            console.log(e), o.text(n), parseInt(e.status) && ($("#loadCategoryHere").append(e.items), cardMediaLoader(), i++, e.hasMore || o.remove())

            for (var e = document.querySelectorAll(".youtube"), i = function (i) {
                var t = "https://img.youtube.com/vi/" + e[i].dataset.embed + "/sddefault.jpg",
                    o = new Image;
                o.src = t, $(o).attr("alt", "Миниатюра видео youtube"), o.addEventListener("load", function () {
                    e[i].appendChild(o)
                }(i)), e[i].addEventListener("click", function () {
                    var e = document.createElement("iframe");
                    e.setAttribute("frameborder", "0"), e.setAttribute("allowfullscreen", ""), e.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1"), this.innerHTML = "", this.appendChild(e)
                })
            }, t = 0; t < e.length; t++) i(t)

        })
    })
});

$(document).ready(function () {
    if ($("#loadHomeMore").length) {
        var e = 24,
            i = 0,
            t = [];
        $("[data-post-id]").each(function (e, i) {
            t.push($(i).attr("data-post-id"))
        })
    }
    $("#loadHomeMore").click(function () {
        var o = e * i,
            n = $(this),
            a = n.text();
        n.text("Загружаем...");
        console.log({
            action: "load_more_home",
            exclude: t,
            offset: o,
            ppp: e
        });
        $.post(ajaxurl, {
            action: "load_more_home",
            exclude: t,
            offset: o,
            ppp: e
        }).done(function (e) {
            console.log(e), n.text(a), parseInt(e.status) && ($("#loadHomeHere").append(e.items), cardMediaLoader(), i++, e.hasMore || n.remove())
        });
    })
});

$(".header .burger").on("click", function (e) {
    e.preventDefault();
    $(".header nav").toggleClass("active");
    $(this).toggleClass("active");
    $("body").toggleClass("no-scroll");
});
