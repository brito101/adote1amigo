$((function(){$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$('form[name="login"]').submit((function(e){e.preventDefault();const a=$(this),s=a.attr("action"),t=a.find('input[name="email"]').val(),o=a.find('input[name="password_check"]').val();$.post(s,{email:t,password:o},(function(e){e.message&&n(e.message,3),e.redirect&&(window.location.href=e.redirect)}),"json")})),$('form[name="newAccount"]').submit((function(e){e.preventDefault();const a=$(this),s=a.attr("action"),t=a.find('input[name="name"]').val(),o=a.find('input[name="email"]').val(),i=a.find('input[name="password_check"]').val();$.post(s,{name:t,email:o,password:i},(function(e){e.message&&n(e.message,3),e.redirect&&(window.location.href=e.redirect)}),"json")})),$('form[name="forgotternAccount"]').submit((function(e){e.preventDefault();const a=$(this),s=a.attr("action"),t=a.find('input[name="email"]').val();$.post(s,{email:t},(function(e){e.message&&n(e.message,3),e.redirect&&(window.location.href=e.redirect)}),"json")})),$('form[name="resetAccount"]').submit((function(e){e.preventDefault();const a=$(this),s=a.attr("action"),t=a.find('input[name="password_check"]').val();$.post(s,{password:t},(function(e){e.message&&n(e.message,3),e.redirect&&(window.location.href=e.redirect)}),"json")}));var e=3;function n(e,n){var a=$(e);a.append("<div class='message_time'></div>"),a.find(".message_time").animate({width:"100%"},1e3*n,(function(){$(this).parents(".message").fadeOut(200)})),$(".ajax_response").append(a)}$(".ajax_response .message").each((function(a,s){n(s,e+=1)})),$(".ajax_response").on("click",".message",(function(e){$(this).effect("bounce").fadeOut(1)}))}));var password=document.getElementById("password"),confirm_password=document.getElementById("confirm_password");if(password&&confirm_password){function validatePassword(){password.value!=confirm_password.value?confirm_password.setCustomValidity("Senhas não conferem!"):confirm_password.setCustomValidity("")}password.onchange=validatePassword,confirm_password.onkeyup=validatePassword}