import './bootstrap';
import * as toast from './jquery.toast';
import * as maskedinput from './jquery.maskedinput';
import * as jqueryui from './jquery-ui';

var idleTime = 0;
const minutesOfInactivity = 30; 
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
                window.location.reload();
            }
        }
    }
);