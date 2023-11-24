jq1 = jQuery.noConflict();
jq1(function($) {
    
    // Dropdown toggle fuction
    $(".dropdown-toggle").click(function(){
        
        if($(this).hasClass("active")){
            $(this).removeClass("active");
        }else{
            $(this).addClass("active");
        }

        $(this).next('.dropdown').slideToggle("fast");
    });

    $(document).on('click', function (e) {
        if(!$(".dropdown-toggle").is(e.target) && !$(".dropdown-toggle").has(e.target).length){
            $(".dropdown").slideUp("fast");
            $(".dropdown-toggle").removeClass("active");
        }
    });

});