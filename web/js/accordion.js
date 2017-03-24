$(function() {
  $('button.accordion').on('click', function() {
    if( !$(this).hasClass('active') ) {
      $(this).siblings('.active').next('.panel').slideToggle();
      $(this).siblings('.active').toggleClass('active');
    }

    $(this).toggleClass('active');
    $(this).next('.panel').slideToggle();
  });
});
