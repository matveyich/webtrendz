$(document).ready(function() {
    $('img.toggleSubArea').click(function(e) {
        var el = $(this).parent().parent().next();

        el.toggle($(el).css('display') == 'none');

        return false;
    });

    $('img.toggleSubArea').parent().parent().next().toggle();

    setTimeout("$('div.message').slideUp('slow');", 2000);
});