$(document).ready(function() {
    setTimeout("$('div.message').slideUp('slow');", 2000);
    setTimeout("$('div.error').slideUp('slow');", 2000);

    $('tbody tr').hover(function() {
        $(this).addClass('highlight');
    }, function() {
        $(this).removeClass('highlight');
    });
});