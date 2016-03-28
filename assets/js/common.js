$(document).ready(function () {
  
  // create vertical dots
  (function(){
    var imgs = $('.b_section-wrap');
    var menu =  $('.vertical-dots-nav');
    $.each(imgs, function(index, val) {
      menu.find('ul').append('<li data-href="'+ $(val).data('id') +'"></li>');
    });
    menu.find('li').click(function(event) {
      console.log($('[data-id='+$(this).data("href")+']').offset().top);
      $('html, body').animate({scrollTop: $('[data-id='+$(this).data("href")+']').offset().top}, 2000, function(){
        console.log('scroll finish');
      });
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

  if (window.innerWidth > 767){
    setTimeout(function(){
      $('.b_page-nav').removeClass('is_shown');
    }, 5000);
  }

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
    if(contacts == '1')
    {
      $('html, body').animate({scrollTop: $('[data-id=11]').offset().top}, 10);

    }
  }());
});

