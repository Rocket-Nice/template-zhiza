    var wamid = '5366'; /* Wam Account ID */
    var typ = '1'; /* Event Type default 1 */

    var Wvar = [];
    Wvar.push('title', document.title.replace(/([\"\'])/g,' '));

    (function () {
        var w = document.createElement("script");
        w.type = "text/javascript";
        w.src = document.location.protocol +
        "//cstatic.weborama.fr/js/wam/customers/wamfactory_dpm.wildcard.min.js?rnd=" + new Date().getTime();
        w.async = true;
        var body = document.getElementsByTagName('script')[0];
        body.parentNode.insertBefore(w, body);
    })();

    (function () {
        'use strict';
        var spent_time = 0;
        var count_spent_time = setInterval(function () {
            spent_time += 30;
            if (spent_time > 120) {
                clearInterval(count_spent_time);
                return;
            }
            window.wamf.eventSend("2", "spent_time", String(spent_time));
        }, 30000);
    })();
