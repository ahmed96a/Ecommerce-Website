/*global $, confirm, console*/


// Trigger Select Box Plugin

$("select").selectBoxIt();


// .Confirm class in delete button in manage section

$(".confirm").click(function(){
    
    return confirm("Do you want to delete that Member?");
    
});



                                        //              Start login.php

// Focus and Blur on input placehoders

$(function(){
    
    $("input:not([type='submit'])").on({
        
        focus: function(){ $(this).attr("data-place", $(this).attr("placeholder"));  $(this).attr("placeholder", ""); },
        
        blur: function(){ $(this).attr("placeholder", $(this).data('place')); }
    });
    
});



// Add * to required inputs

$("input[required]").after("<span class='asterik'>*</span>");


// Select which form to show

$(".logsign h1 span").click(function(){
    
    $(this).addClass("active").siblings("span").removeClass("active");
    
    if($(this).hasClass("login"))
    {
        $(this).css("color","#1b4e7a");
        $(this).siblings("span").css("color","#333333");
        $(".logsign form.login").fadeIn().siblings("form.signup").hide();
    }
    else
    {
        $(this).css("color","#1a951a");
        $(this).siblings("span").css("color","#333333");
        $(".logsign form.signup").fadeIn().siblings("form.login").hide();
    }
    
});

                                        //              End login.php


                                        //              Start ads.php

// form with item-box preview

$(".ad form [name='itemName']").keyup(function(){
    
    $(".ad .item-box .caption h4").text($(this).val());
    
});

$(".ad form [name='itemDescription']").keyup(function(){
    
    $(".ad .item-box .caption p").text($(this).val());
    
});

$(".ad form [name='itemPrice']").keyup(function(){
    
    $(".ad .item-box .price").text('$' + $(this).val());
    
});

$(".live").keyup(function(){
    
    console.log($(this));
});

                                        //              End ads.php
