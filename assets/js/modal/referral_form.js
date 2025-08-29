$(document).ready(function() {
    function searchICD(query, type) {
        // if(query.length < 2) {
        //     $("#icdSuggestions").hide();
        //     return;
        // }

        console.log('Searching ICD for:', query, 'of type:', type);

        $.ajax({
            url: "../../assets/php/patient_registration_form/get_search_icd.php",  // your backend ICD search
            method: "GET",
            data: { q: query, type: type }, 
            datatype: "json",
            success: function(data) {
                console.log(data)
                let results = data
                let suggestionBox = $("#icdSuggestions");
                suggestionBox.empty();
                
                if(results.length > 0) {
                    results.forEach(item => {
                    suggestionBox.append(
                        `<button type="button" class="list-group-item list-group-item-action icd-option" data-code="${item.code}" data-title="${item.title}">
                        ${item.code} - ${item.title}
                        </button>`
                    );
                    });
                    suggestionBox.show();
                } else {
                    suggestionBox.hide();
                }
            }
        });
    }

    // Trigger search on typing
    $("#icdCode").on("keyup", function() {
        console.log('here')
        searchICD($(this).val(), "code");
    });

    $("#icdTitle").on("keyup", function() {
        searchICD($(this).val(), "title");
    });

    // Selecting a result
    $(document).on("click", ".icd-option", function() {
        $("#icdCode").val($(this).data("code"));
        $("#icdTitle").val($(this).data("title"));
        $("#icdSuggestions").hide();
    });
});
