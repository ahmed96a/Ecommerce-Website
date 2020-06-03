/*global $, confirm*/


// Trigger Select Box Plugin

$("select").selectBoxIt();


                                        //              Start index.php

// Focus and Blur on input placehoders

$(function(){
    
    $("input:not([type='submit'])").on({
        
        focus: function(){ $(this).attr("data-place", $(this).attr("placeholder"));  $(this).attr("placeholder", ""); },
        
        blur: function(){ $(this).attr("placeholder", $(this).data('place')); }
    });
    
});

                                        //              End index.php

                                        //              Start dashboard.php

// i.fa-plus , i.fa-minus collapse

$(".latest .panel-heading i.select").on("click", function(){
    
    $(this).parent(".panel-heading").next(".panel-body").slideToggle(500);
    if($(this).hasClass("fa-plus"))
    {
        $(this).removeClass("fa-plus").addClass("fa-minus");
    }
    else
    {
        $(this).removeClass("fa-minus").addClass("fa-plus");
    }
});


                                        //              End dashboard.php

                                        //              Start members.php


// Show Pass in the forms

$("input[required]").after("<span class='asterik'>*</span>");


$(".show-pass").hover(function(){
    
    $(this).prev().prev().attr("type","text");
    
},function(){
    
    $(this).prev().prev().attr("type","password");
    
});

// .Confirm class in delete button in manage section

$(".confirm").click(function(){
    
    return confirm("Do you want to delete that Member?");
    
});



                                        //              End members.php

                                        //              Start categories.php

// Manage Section show or hide the .cat-detail

$(".category .cat h4").click(function(){
    
    $(this).next(".cat-detail").fadeToggle();
    
});

                                        //              End categories.php
