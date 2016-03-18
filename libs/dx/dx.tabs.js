// -------------------------------------------------------------------------------------------
// Tabs
// -------------------------------------------------------------------------------------------

(function ($) {

$.fn.tabs = function (){
    var div = $(this);
    var nav_ul = div.find('ul.nav');
    var nav_select = div.find('select.nav');
    var content = div.find('.content');
    nav_ul.find('li:first-child').addClass('active');
    nav_ul.find('option:first-child').prop('selected', true);
    content.find('li:first-child').addClass('active');

    nav_ul.find('li a').click(function(){
        change_tab($(this).attr('href'));
        return false;
    });

    nav_select.change(function(){
        change_tab($(this).val());
        return false;
    });

    var change_tab = function (datatarget) {
        // ul
        nav_ul.find('li').removeClass('active');
        nav_ul.find('li a[href="'+datatarget+'"]').parent().addClass("active");
        // select
        nav_select.find('option').prop('selected', false);
        nav_select.find('option[value="'+datatarget+'"]').prop('selected', true);
        // content
        content.find('li.active').removeClass('active');
        content.find('li'+datatarget).addClass('active');
    }
}

$(document).on("ready", function(){
    if($.fn.tabs) {
        $('.tabs').each(function(){
            $(this).tabs();
        });
        $.event.trigger({
          type:    "tabsReady",
          message: "Tabs Ready",
          time:    new Date()
        });
    }
});

})(jQuery);