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
})