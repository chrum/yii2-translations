$(document).ready(function() {
    $("#addMore").click(function(event){
        event.preventDefault();
        var clone = $("#emptyRow").clone();
        clone.removeClass("hidden");
        clone.attr("id", "");
        $("#stringsContainer").append(clone);
    });

    $(".table-row-link").click(function(event) {
        event.preventDefault();
        event.stopImmediatePropagation();
        var target = $(event.target);
        var rowLink = target.data("row-link");
        if (typeof(rowLink) == 'undefined') {
            rowLink = target.parent().data("row-link");
        }
        document.location.href = rowLink;
        return false;
    });

    $(".form-submit").click(function() {
        $("#namespace-form").submit();
    });
    $(".delete").click(function(event) {
        if (!confirm("Are you sure you want to delete this namespace?")) {
            event.preventDefault();
        }
    })
});