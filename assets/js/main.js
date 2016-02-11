$(document).ready(function () {
  // create vertical dots
  (function(){
    var imgs = $('.b_section-wrap');
    var menu =  $('.vertical-dots-nav');
    $.each(imgs, function(index, val) {
      menu.find('ul').append('<li data-href="'+ $(val).data('id') +'"></li>');
    });
    menu.find('li').click(function(event) {
      $('html, body').animate({scrollTop: $('[data-id='+$(this).data("href")+']').offset().top}, 2000);
    });
    var wh = window.innerHeight;
    menu.css({
      'margin-top':(wh - menu.height())/2 -100 +'px'
    });
  }());

  // init cusom scrollbar
  $(".default-skin").customScrollbar();

  // remove loader form page
  setTimeout(function(){
    $('body').addClass('loaded');
  }, 1000);

  // block scroller & links
  (function(){
    var blockScroller =  $(".b_sections-container").blockScroll({
      scrollDuration:400,
      fadeBlocks: false,
      fadeDuration: 200
    });
    var links =  $('.b_page-nav_list a[href="#"]');
    links.bind('click', function(e){
      e.preventDefault();
      var n = $(this).data('href');
      $('html, body').animate({scrollTop: $('[data-id='+n+']').offset().top}, 2000);
    });
  }());
});


function dropdownToggle(state){
  var dropdown = $('#bulk_actions');
  if(state){
    dropdown.removeClass('disabled');
  }else{
    dropdown.addClass('disabled');
  }
}

function deleteConfirmation(url){
  var modal = $('#confirmationModal');
  $('#deleteConfirm').data('url', url);
  $(modal).modal();
}