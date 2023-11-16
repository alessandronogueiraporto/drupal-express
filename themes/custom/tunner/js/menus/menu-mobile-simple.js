/*(function ($, Drupal) {

  alert("teste");

       $('a').click(function(){
         $('.menu-hide').toggleClass('show');
         $('.menu-tab').toggleClass('active');
       });

       $('a').click(function(){
         $('.menu-hide').removeClass('show');
         $('.menu-tab').removeClass('active');
       });


}(jQuery, Drupal));
*/

(function ($, Drupal) {

  // Dropdown toggle fuction
  $('.dropdown-toggle').click(function(){
    $(this).next('.dropdown').slideToggle("fast");
  });

  $(document).on('click', function (e) {
      if(!$(".dropdown-toggle").is(e.target) && !$(".dropdown-toggle").has(e.target).length){
          $('.dropdown').slideUp("fast");
      }                       
  });

});