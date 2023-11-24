(function ($, Drupal) {

    //Control hight menu mobile admin toolbar
    if( $('html').find('#toolbar-administration').length){
        //alert("login");
        currentHeight = $('#toolbar-administration').outerHeight();
        $('#menu-mobile').css( { height: `calc(100vh - ${currentHeight}px)` } );
        $("#menu-mobile").css("top",currentHeight+"px");      
     }else{
        //alert("Logout");
     }

     //Control menus Desktop/Mobile
     //Get windows size
     $('#container-menu-desktop').hide();
     $("#container-menu-desktop").detach().appendTo("#header");

     if ($(window).width() > 964) {
      //alert('Less than 964');
      $('#btn-menu-mobile').hide();
     }
     else {
      //alert('More than 964');
      $('#btn-menu-desktop').hide();
     }

     $(window).resize(function() {
      if ($(window).width() > 964) {
         //alert('Less than 960');
         $('#btn-menu-mobile').hide();
      }
     else {
         $('#btn-menu-desktop').hide();
     }
    });
    
      //****************************************************//
      //Control tabs menu mobile
      //****************************************************//
      
      //Desktop button
      //****************************************************//
      $('#btn-menu-desktop').click(function() {

         if ($(".slide-menu-desktop").is(":visible")) {

            $('#container-menu-desktop').delay(100).fadeOut();
            $('#menu-desktop').removeClass('slide-menu-desktop');

          } else {

            $("#container-menu-desktop").fadeIn();
            setTimeout(function() {
               $('#menu-desktop').addClass('slide-menu-desktop');
            }, 100);
            
          }

      });

      //Mobile button
      //****************************************************//
      $( "#btn-menu-mobile" ).click(function() {
         $('#menu-mobile').toggleClass('slide-menu-mobile');
         alert("teste mobile");
      });

      //****************************************************//
      //End//
      //****************************************************//

      //Control display tabs images
      $('.image-tab-0').hide();
      $('#image-tab-1').show();

      //Control display tabs menu
      $('.tabs-nav li:first-child').addClass('active');
      $('.tab-content').hide();
      $('.tab-content:first').show();

      // Click function
      $('#tabs-nav li').click(function(){
         $('#tabs-nav li').removeClass('active');
         $(this).addClass('active');
         $('.tab-content').hide();

         //Click button to change tabs menu content
         var activeTab = $(this).find('button').attr('name');
         ImageactiveTab = '#image-'+activeTab;
         activeTab = '#'+activeTab;

         //Control image
         $('.image-tab').hide();
         //$(ImageactiveTab).show();
         $(ImageactiveTab).fadeIn();

         //Control container tab menus
         $(activeTab).fadeIn();

        return false;
      });

}(jQuery, Drupal));