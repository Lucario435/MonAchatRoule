import './bootstrap';
import jQuery from 'jquery';
const $ = jQuery;

$(
    function() 
    {
        $("#notification").on("change",(e)=>{
            // if($("#notification").is(":checked"))
            //     console.log(e.target.value);
            // else
            //     console.log(e.target.value);

            $("#notification").val($("#notification").is(":checked"));      
            
        })
    }
);