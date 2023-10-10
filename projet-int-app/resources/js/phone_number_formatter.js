import './bootstrap';
import jQuery from 'jquery';
const $ = jQuery;

$("#phone").on("input",()=>{
    let number = $("#phone").val().replace(new RegExp('-','g'),"");
    number = number.replace(/[^0-9]/g, '');
    let formatedNumber;
    let ac = number.substring(0,3);
    let prefix = number.substring(3,6);
    let suffix = number.substring(6,10);
    if (ac.length > 0 && prefix.length > 0 && suffix.length > 0)
        formatedNumber = `${ac}-${prefix}-${suffix}`;
    else if(prefix.length == 0)
        formatedNumber = `${ac}`;
    else if(suffix.length == 0)
        formatedNumber = `${ac}-${prefix}`
    //console.log(formatedNumber);
    $("#phone").val(formatedNumber);
})

