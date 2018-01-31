$(document).ready(function() {
    $(".form-submit").click(function() {
        $("#namespace-form").submit();
    });
    $(".delete").click(function(event) {
        if (!confirm("Are you sure you want to delete this namespace?")) {
            event.preventDefault();
        }
    })
});