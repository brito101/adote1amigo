$((function(){$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$("#price-range").slider({range:!0,min:0,max:99e3,values:[0,99e3],slide:function(e,a){if($("#price_base_input").val(a.values[0].toLocaleString("pt-BR",{style:"currency",currency:"BRL"})),$("#price_limit_input").val(a.values[1].toLocaleString("pt-BR",{style:"currency",currency:"BRL"})),0==a.handleIndex){let e=$("#base");$.post(e.data("action"),{search:a.values[0]})}if(1==a.handleIndex){let e=$("#limit");$.post(e.data("action"),{search:a.values[1]}).done((function(e){let a=e.data.filter((function(e){if(!isNaN(e))return e})),t=a.reduce((function(e,a){return Math.min(e,a)}),a[0]),n=a.reduce((function(e,a){return Math.max(e,a)}),a[0]);$("#year-range").slider({range:!0,min:t,max:n,values:[t,n],slide:function(e,a){$("#year_base_input").val(a.values[0]),$("#year_limit_input").val(a.values[1])}}),$("#year_base_input").val($("#year-range").slider("values",0)),$("#year_limit_input").val($("#year-range").slider("values",1))}))}}}),$("#price_base_input").val($("#price-range").slider("values",0).toLocaleString("pt-BR",{style:"currency",currency:"BRL"})),$("#price_limit_input").val($("#price-range").slider("values",1).toLocaleString("pt-BR",{style:"currency",currency:"BRL"})),$("#year-range").slider({range:!0,min:1980,max:(new Date).getFullYear()+1,values:[0,9999],slide:function(e,a){if($("#year_base_input").val(a.values[0]),$("#year_limit_input").val(a.values[1]),0==a.handleIndex){let e=$("#year_base");$.post(e.data("action"),{search:a.values[0]})}if(1==a.handleIndex){let e=$("#year_limit");$.post(e.data("action"),{search:a.values[1]})}}}),$("#year_base_input").val($("#year-range").slider("values",0)),$("#year_limit_input").val($("#year-range").slider("values",1)),$("#mileage-range").slider({range:!1,min:0,max:1e5,values:[1e5],slide:function(e,a){$("#mileage_input").val(Intl.NumberFormat("pt-BR").format(a.values[0]));let t=$("#mileage");$.post(t.data("action"),{search:a.values[0]})}}),$("#mileage_input").val(Intl.NumberFormat("pt-BR").format($("#mileage-range").slider("values",0))),$(".check_filter").change((function(){let e=[];if($(".check_filter input:checked").each((function(){e.push(this.value)})),e.length>0){$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}});let a=$(this);$.post(a.data("action"),{search:e})}}))}));