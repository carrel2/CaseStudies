$(function() {
  $('button.accordion').on('click', function() {
    if( !$(this).hasClass('active') ) {
      $('button.accordion.active').next('.panel').slideToggle();
      $('button.accordion.active').toggleClass('active');
    }

    $(this).toggleClass('active');
    $(this).next('.panel').slideToggle();
  });
});
