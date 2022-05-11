jQuery(document).ready(function () {

    jQuery(document).on("submit", "form", function () {
        if (handlePublishValidation() > 0) {
            toastr.error("Number of errors " + handlePublishValidation(), "Show errors below");
            return false;
        }
    });
});
