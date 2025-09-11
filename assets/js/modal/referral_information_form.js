$(document).ready(function() {
    $(".preemptive-text .selectable").on("click", function(){
        let textarea = $("#er-action");
        let textToAdd = $(this).text();

        if($.trim(textarea.val()) !== ""){
            textarea.val(textarea.val() + "\n" + textToAdd);
        } else {
            textarea.val(textToAdd);
        }
    });

    $("#select-response-status").on("change", function () {
        let selected = $(this).val();

        if (selected === "Approved" || selected === "Deferred") {
            $(".approval-form-div").slideDown(300); // smoother than show()

            // Scroll inside the modal body (must target modal-body, not modal wrapper)
            let modalBody = $("#patient-referral-modal");
            modalBody.animate({
                scrollTop: $(".approval-form-div").offset().top - modalBody.offset().top + modalBody.scrollTop() - 50
            }, 600);

            if (selected === "Approved") {
                $('#approval-deferral-form-title').text("Approval Form");
                $('#approve-deferred-submit-btn').text("Approve Referral");
                $('.preemptive-text').show();
            } else {
                $('#approval-deferral-form-title').text("Deferral Form");
                $('#approve-deferred-submit-btn').text("Defer Referral");
                $('.preemptive-text').hide();
            }
        } else {
            $(".approval-form-div").slideUp(300);
        }
    });

})