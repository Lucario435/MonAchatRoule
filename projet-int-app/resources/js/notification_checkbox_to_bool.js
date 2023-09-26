import './bootstrap';
import jQuery from 'jquery';
const $ = jQuery;

$(
    function() 
    {
        $("#email_notification").val($("#email_notification").is(":checked")? '1':'0');
        $("#email_notification").on("change",(e)=>{

            $("#email_notification").val($("#email_notification").is(":checked")? '1':'0');      
            
        })
    }
);