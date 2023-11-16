(function ($, Drupal) {
    
    $( ".btn-menu-01" ).click(function() {
        $(".coh-menu-list-container").find(".menu-level-2").slideToggle("fast");
    });
    
    $(document).on("click", function(event){
        var $trigger = $(".coh-menu-list-container");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $(".menu-level-2").slideUp("fast");
        }            
    });
    
}(jQuery, Drupal));