$(document).ready(function() {
    $("#addMore").click(function(event){
        event.preventDefault();
        var clone = $("#emptyRow").clone();
        clone.removeClass("hidden");
        clone.attr("id", "");
        $("#stringsContainer").append(clone);
    });
});