import './bootstrap';
import jQuery from 'jquery';
const $ = jQuery;

$(
    function() 
    {
        $("#email_notification").val($("#email_notification").is(":checked")? true:false);
        $("#email_notification").on("change",(e)=>{
            // if($("#notification").is(":checked"))
            //     console.log(e.target.value);
            // else
            //     console.log(e.target.value);
            $("#email_notification").val($("#email_notification").is(":checked")? true:false);      
            
        })
    }
);