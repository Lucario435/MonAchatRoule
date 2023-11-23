import './bootstrap';
import * as toast from './jquery.toast';
import * as maskedinput from './jquery.maskedinput';
import * as jqueryui from './jquery-ui';
import './resize.js';
import './filterUI.js';
import './ImageControl.js';
import './location.js';
import './notification_checkbox_to_bool.js';
import './refreshNotifications.js';
import './show_hide_password.js';
import './snap_header_filters.js';
import './validation.js';

var idleTime = 0;
const minutesOfInactivity = 15; 
$(
    function () {
        // https://stackoverflow.com/a/4029518 
        // Increment the idle time counter every minute.
        var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
       
        // Zero the idle timer on mouse movement.
        $(this).on("mousemove",function (e) {
            idleTime = 0;
        });
        $(this).on("keypress",function (e) {
            idleTime = 0;
        });

        function timerIncrement() {
            idleTime = idleTime + 1;
            console.log(idleTime);
            if (idleTime >= minutesOfInactivity) {
                $.ajax({
                    url: '/logout',
                    async: false,
                    success: function (data) {
                        window.location.reload();
                    },
                    error: (xhr) => { console.log(xhr); }
                });
            }
        }
    }
);