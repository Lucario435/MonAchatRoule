import './bootstrap';
import jQuery from 'jquery';
const $ = jQuery;

// Mécanisme pour montrer mot de passe tiré de ASP chat manager 
// prof : nicolas chourot

$("#toggleShowPassword").hide();
$("#toggleShowPassword").on("click",() => {
    $("#password").attr("type", $("#password").attr("type") == 'password' ? 'text' : 'password');
    $("#password_confirm").attr("type", $("#password_confirm").attr("type") == 'password' ? 'text' : 'password');
    $("#toggleShowPassword").toggleClass("fa-eye");
    $("#toggleShowPassword").toggleClass("fa-eye-slash");
});
$("#password").on("keyup",() => {
    if ($("#password").val() == "")
        $("#toggleShowPassword").hide();
    else
        $("#toggleShowPassword").show();
})