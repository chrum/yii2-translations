$(document).ready(function() {
    var displayedLangsTimeout;
    $('.displayed-lang-label').click(function() {
        clearTimeout(displayedLangsTimeout);
        displayedLangsTimeout = setTimeout(function() {
            var selected = [];
            $('.displayed-lang-checkbox:checked').each(function(key, input) {
                selected.push($(input).attr('name'));
            });

            window.location.href = listUrl + '?display=' + selected.join(',');
            console.log(JSON.stringify(selected));
        }, 500)
    });
});