import './bootstrap';
import jQuery from 'jquery';
const $ = jQuery;

$(
    function() 
    {
        console.log("notification box on line");
        $("#email_notification").val($("#email_notification").is(":checked")? '1':'0');
        $("#email_notification").on("change",(e)=>{
            $("#email_notification").val($("#email_notification").is(":checked")? '1':'0');      
            console.log( $("#email_notification").val());
        })
    }
);