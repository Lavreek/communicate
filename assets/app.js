/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

const $ = require('jquery');

require('jquery-ui/dist/jquery-ui');
require('js-datepicker/src/datepicker');

import './scripts/FormSender'

$(document).ready(function () {
    $('#profile_birthday').datepicker({
        dateFormat : 'yy-mm-dd'
    });

    if ($('.container-messages') !== null) {
        let div = $('.container-messages');

        div.animate({
            scrollTop: div[0].scrollHeight
        }, 1000);

        setInterval(() => {
            $.ajax({
                method: 'POST',
                url: '/api/message/get',
                data: "url=" + document.location.href,
                contentType: 'application/x-www-form-urlencoded;charset=utf-8',

                success: function (response) {
                    for (let i = 0; i < response.messages.length; i++) {
                        let message = response.messages[i];

                        if ($('#message-' + message.id).length < 1) {
                            if (message.from === "user") {
                                $('.container-messages').append("<div id='message-"+ message.id  + "' class=\"card w-75 mb-3\"><div class=\"px-2\"><p>" + message.text + "</p></div></div>");

                                let div = $('.container-messages');

                                div.animate({
                                    scrollTop: div[0].scrollHeight
                                }, 1000);

                            } else if (message.from === "vis") {
                                $('.container-messages').append("<div id='message-"+ message.id + "' style='margin-left: 25%;' class=\"card w-75 mb-3\"><div class=\"px-2\"><p>" + message.text + "</p></div></div>");

                                let div = $('.container-messages');

                                div.animate({
                                    scrollTop: div[0].scrollHeight
                                }, 1000);
                            }
                        }
                    }
                }
            });
        }, 1000)
    }
});

