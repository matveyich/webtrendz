$(document).ready(function() {
    $('div.scrollable').scrollable({
        api: true,
        size: 3,
        clickable: false,
        prev: '#prev_image',
        next: '#next_image'
    });
});